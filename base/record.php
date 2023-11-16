<?php
require("../require/db_login.php");

$fullPath = __DIR__ . '/info' ;
array_map('unlink', glob( "$fullPath/*.txt"));

$paciente = $_POST['paciente'];
$dataNasc_input = $_POST['dataNasc'];
$dataNasc_change = explode("-", $dataNasc_input);
$dataNasc_reverse = array_reverse($dataNasc_change);
$dataNasc = implode("-", $dataNasc_reverse);

fopen("./info/$paciente.txt", "w");
fopen("./info/$dataNasc.txt", "w");
?>

<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Informa&ccedil;&otilde;es do Paciente</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="../CSS/global.css">
    <link rel="stylesheet" href="../CSS/record.css">
    <link rel="shortcut icon" href="../img/phone.png" type="image/x-icon">
    <script src="../JS/DetectRTC.js"></script>
    <script src="../JS/RecordRTC.js"> </script>
</head>

<body>
    <div class="container-record">
        <div class="box-record">
            <h1>Informa&ccedil;&otilde;es do Paciente</h1>
            <div class="info">
                <?php
                echo "Paciente: $paciente <br>";
                echo "Data de nascimento: $dataNasc";
                ?>
            </div>
            <div class="button-record">
                <section class="experiment recordrtc">
                    <h2 class="header">
                        <div class="invisivel">
                            <select class="recording-media">
                                <option value="record-audio">Audio</option>
                            </select>

                            formato
                            <select class="media-container-format">
                                <option>WAV</option>
                            </select>
                        </div>

                        <button>Come&ccedil;ar a Gravar</button>
                    </h2>

                    <div style="display: none;">
                        <button id="upload-to-server" name="upload-to-server">Enviar</button>
                    </div>

                    <video></video>
                </section>
            </div>
        </div>
    </div>

    <!--  -->
    <script>
        (function() {
            var params = {},
                r = /([^&=]+)=?([^&]*)/g;

            function d(s) {
                return decodeURIComponent(s.replace(/\+/g, ' '));
            }

            var match, search = window.location.search;
            while (match = r.exec(search.substring(1))) {
                params[d(match[1])] = d(match[2]);

                if (d(match[2]) === 'true' || d(match[2]) === 'false') {
                    params[d(match[1])] = d(match[2]) === 'true' ? true : false;
                }
            }

            window.params = params;
        })();

        var recordingDIV = document.querySelector('.recordrtc');
        var recordingMedia = recordingDIV.querySelector('.recording-media');
        var recordingPlayer = recordingDIV.querySelector('video');
        var mediaContainerFormat = recordingDIV.querySelector('.media-container-format');

        recordingDIV.querySelector('button').onclick = function() {
            var button = this;

            if (button.innerHTML === 'Parar de Gravar') {
                button.disabled = true;
                button.disableStateWaiting = true;
                setTimeout(function() {
                    button.disabled = false;
                    button.disableStateWaiting = false;
                }, 2 * 1000);

                button.innerHTML = 'Começar a Gravar';

                function stopStream() {
                    if (button.stream && button.stream.stop) {
                        button.stream.stop();
                        button.stream = null;
                    }
                }

                if (button.recordRTC) {
                    if (button.recordRTC.length) {
                        button.recordRTC[0].stopRecording(function(url) {
                            if (!button.recordRTC[1]) {
                                button.recordingEndedCallback(url);
                                stopStream();

                                saveToDiskOrOpenNewTab(button.recordRTC[0]);
                                return;
                            }

                            button.recordRTC[1].stopRecording(function(url) {
                                button.recordingEndedCallback(url);
                                stopStream();
                            });
                        });
                    } else {
                        button.recordRTC.stopRecording(function(url) {
                            button.recordingEndedCallback(url);
                            stopStream();

                            saveToDiskOrOpenNewTab(button.recordRTC);
                        });
                    }
                }

                return;
            }

            button.disabled = true;

            var commonConfig = {
                onMediaCaptured: function(stream) {
                    button.stream = stream;
                    if (button.mediaCapturedCallback) {
                        button.mediaCapturedCallback();
                    }

                    button.innerHTML = 'Parar de Gravar';
                    button.disabled = false;
                },
                onMediaStopped: function() {
                    button.innerHTML = 'Começar a Gravar';

                    if (!button.disableStateWaiting) {
                        button.disabled = false;
                    }
                },
                onMediaCapturingFailed: function(error) {
                    if (error.name === 'PermissionDeniedError' && !!navigator.mozGetUserMedia) {
                        InstallTrigger.install({
                            'Foo': {
                                URL: 'https://addons.mozilla.org/en-US/firefox/addon/enable-screen-capturing/',
                                toString: function() {
                                    return this.URL;
                                }
                            }
                        });
                    }

                    commonConfig.onMediaStopped();
                }
            };

            if (recordingMedia.value === 'record-audio') {
                captureAudio(commonConfig);

                button.mediaCapturedCallback = function() {
                    button.recordRTC = RecordRTC(button.stream, {
                        type: 'audio',
                        bufferSize: typeof params.bufferSize == 'undefined' ? 0 : parseInt(params.bufferSize),
                        sampleRate: typeof params.sampleRate == 'undefined' ? 44100 : parseInt(params.sampleRate),
                        leftChannel: params.leftChannel || false,
                        disableLogs: params.disableLogs || false,
                        recorderType: DetectRTC.browser.name === 'Edge' ? StereoAudioRecorder : null
                    });

                    button.recordingEndedCallback = function(url) {
                        var audio = new Audio();
                        audio.src = url;
                        audio.controls = true;
                        recordingPlayer.parentNode.appendChild(document.createElement('hr'));
                        recordingPlayer.parentNode.appendChild(audio);

                        if (audio.paused) audio.play();

                        audio.onended = function() {
                            audio.pause();
                            audio.src = URL.createObjectURL(button.recordRTC.blob);
                        };
                    };

                    button.recordRTC.startRecording();
                };
            }
        };

        function captureAudio(config) {
            captureUserMedia({
                audio: true
            }, function(audioStream) {
                recordingPlayer.srcObject = audioStream;

                config.onMediaCaptured(audioStream);

                audioStream.onended = function() {
                    config.onMediaStopped();
                };
            }, function(error) {
                config.onMediaCapturingFailed(error);
            });
        }

        function captureUserMedia(mediaConstraints, successCallback, errorCallback) {
            navigator.mediaDevices.getUserMedia(mediaConstraints).then(successCallback).catch(errorCallback);
        }

        function setMediaContainerFormat(arrayOfOptionsSupported) {
            var options = Array.prototype.slice.call(
                mediaContainerFormat.querySelectorAll('option')
            );

            var selectedItem;
            options.forEach(function(option) {
                option.disabled = true;

                if (arrayOfOptionsSupported.indexOf(option.value) !== -1) {
                    option.disabled = false;

                    if (!selectedItem) {
                        option.selected = true;
                        selectedItem = option;
                    }
                }
            });
        }

        recordingMedia.onchange = function() {
            if (this.value === 'record-audio') {
                setMediaContainerFormat(['WAV', 'Ogg']);
                return;
            }
            setMediaContainerFormat(['WebM', /*'Mp4',*/ 'Gif']);
        };

        if (false && DetectRTC.browser.name === 'Chrome') {
            recordingMedia.innerHTML = '<option value="record-audio-plus-video">Audio+Video</option>' +
                recordingMedia.innerHTML;
            console.info('This RecordRTC demo merely tries to playback recorded audio/video sync inside the browser. It still generates two separate files (WAV/WebM).');
        }

        var MY_DOMAIN = '../';

        function isMyOwnDomain() {
            return document.domain.indexOf(MY_DOMAIN) !== -1;
        }

        function saveToDiskOrOpenNewTab(recordRTC) {
            recordingDIV.querySelector('#upload-to-server').parentNode.style.display = 'block';

            var EnviarSalvar = document.querySelectorAll('.experiment div')[1]
            EnviarSalvar.style = 'display: flex; justify-content: center;';

            if (isMyOwnDomain()) {
                recordingDIV.querySelector('#upload-to-server').disabled = true;
                recordingDIV.querySelector('#upload-to-server').style.display = 'none';
            } else {
                recordingDIV.querySelector('#upload-to-server').disabled = false;
            }

            recordingDIV.querySelector('#upload-to-server').onclick = function() {
                if (isMyOwnDomain()) {
                    alert('PHP Upload is not available on this domain.');
                    return;
                }

                if (!recordRTC) return alert('No recording found.');
                this.disabled = true;

                var button = this;
                uploadToServer(recordRTC, function(progress, fileURL) {
                    buttonGravar = document.querySelector('h2.header button').style.visibility = 'hidden';
                    if (progress === 'ended') {
                        document.querySelector('.experiment audio').style.visibility = 'hidden';
                        document.querySelector('.experiment hr').style.visibility = 'hidden';
                        button.disabled = false
                        button.innerHTML = 'Salvar Áudio';
                        button.onclick = () => {
                            location.assign("./post-record.php")
                        };
                        return;
                    }
                    button.innerHTML = progress;
                });
            };
        }

        var listOfFilesUploaded = [];

        function uploadToServer(recordRTC, callback) {
            var blob = recordRTC instanceof Blob ? recordRTC : recordRTC.blob;
            var fileType = blob.type.split('/')[0] || 'audio';

            const date = new Date()
            var data_atual = date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
            var hora_atual = date.getHours() + 'h' + date.getMinutes() + 'min';

            var prefixName = location.pathname.replace('/postos/', '')
            prefixName = prefixName.replace('/', '').toUpperCase()
            var fileName = 'Dia ' + data_atual + ' - Horário ' + hora_atual;

            if (fileType === 'audio') {
                fileName += '.' + (!!navigator.mozGetUserMedia ? 'ogg' : 'wav');
            } else {
                fileName += '.webm';
            }

            var formData = new FormData();
            formData.append(fileType + '-filename', fileName);
            formData.append(fileType + '-blob', blob);

            callback('Uploading ' + fileType + ' recording to server.');

            var upload_url = './save.php';

            var upload_directory = './pre-upload/';

            makeXMLHttpRequest(upload_url, formData, function(progress) {
                if (progress !== 'upload-ended') {
                    callback(progress);
                    return;
                }

                callback('ended', upload_directory + fileName);

                listOfFilesUploaded.push();
            });
        }

        function makeXMLHttpRequest(url, data, callback) {
            var request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    callback('upload-ended');
                }
            };

            request.upload.onloadstart = function() {
                callback('Upload started...');
            };

            request.upload.onprogress = function(event) {
                callback('Upload Progress ' + Math.round(event.loaded / event.total * 100) + "%");
            };

            request.upload.onload = function() {
                callback('progress-about-to-end');
            };

            request.upload.onload = function() {
                callback('progress-ended');
            };

            request.upload.onerror = function(error) {
                callback('Failed to upload to server');
                console.error('XMLHttpRequest failed', error);
            };

            request.upload.onabort = function(error) {
                callback('Upload aborted.');
                console.error('XMLHttpRequest aborted', error);
            };

            request.open('POST', url);
            request.send(data);
        }

        window.onbeforeunload = function() {
            recordingDIV.querySelector('button').disabled = false;
            recordingMedia.disabled = false;
            mediaContainerFormat.disabled = false;

            if (!listOfFilesUploaded.length) return;

            var delete_url = './delete.php';

            listOfFilesUploaded.forEach(function(fileURL) {
                var request = new XMLHttpRequest();
                request.onreadystatechange = function() {
                    if (request.readyState == 4 && request.status == 200) {
                        if (this.responseText === ' problem deleting files.') {
                            alert('Failed to delete ' + fileURL + ' from the server.');
                            return;
                        }

                        listOfFilesUploaded = [];
                        alert('You can leave now. Your files are removed from the server.');
                    }
                };
                request.open('POST', delete_url);

                var formData = new FormData();
                formData.append('delete-file', fileURL.split('/').pop());
                request.send(formData);
            });

            return 'Please wait few seconds before your recordings are deleted from the server.';
        };
    </script>
</body>
</html>