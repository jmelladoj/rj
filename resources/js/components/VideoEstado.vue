<template>
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h4 class="text-themecolor">Vídeo estados</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                            <li class="breadcrumb-item active">Vídeo estados</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form">
                                <div class="form-group row">
                                    <div class="col-md-3"><button class="btn btn-block btn-info" id="start">INICIAR CAMARA</button></div>
                                    <div class="col-md-3"><button class="btn btn-block btn-success" id="record" disabled>GRABAR VÍDEO</button></div>
                                    <div class="col-md-3"><button class="btn btn-block btn-warning" id="play" disabled>REPRODUCIR</button></div>
                                    <div class="col-md-3"><button class="btn btn-block btn-danger" id="download" disabled>DESCARGAR Y SUBIR</button></div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <video id="gum" playsinline autoplay class="embed-responsive-item"></video>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <video id="recorded" playsinline loop class="embed-responsive-item"></video>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
<script>
    export default {
        data() {
            return {

            }
        },    
        mounted(){
            'use strict';

            const mediaSource = new MediaSource();
            mediaSource.addEventListener('sourceopen', handleSourceOpen, false);

            let mediaRecorder;
            let recordedBlobs;
            let sourceBuffer;

            const recordedVideo = document.querySelector('video#recorded');
            const recordButton = document.querySelector('button#record');

            recordButton.addEventListener('click', () => {
                if (recordButton.textContent === 'GRABAR VÍDEO') {
                    startRecording();
                } else {
                    stopRecording();
                    recordButton.textContent = 'GRABAR VÍDEO';
                    playButton.disabled = false;
                    downloadButton.disabled = false;
                }
            });

            const playButton = document.querySelector('button#play');
                playButton.addEventListener('click', () => {
                const superBuffer = new Blob(recordedBlobs, {type: 'video/webm'});
                recordedVideo.src = null;
                recordedVideo.srcObject = null;
                recordedVideo.src = window.URL.createObjectURL(superBuffer);
                recordedVideo.controls = true;
                recordedVideo.play();
            });

            const downloadButton = document.querySelector('button#download');
            downloadButton.addEventListener('click', () => {
                const blob = new Blob(recordedBlobs, {type: 'video/webm'});
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');

                let formData = new FormData();
                formData.append('video', blob);

                axios.post('/video/estado/crear', formData).then(function (response) {
                    swal.fire({
                        type: 'success',
                        title: 'Vídeo estado cargado correctamente',
                        showConfirmButton: false,
                        timer: 2000
                    });

                    a.style.display = 'none';
                    a.href = url;
                    a.download = 'video.webm';
                    document.body.appendChild(a);
                    a.click();
                    setTimeout(() => {
                        document.body.removeChild(a);
                        window.URL.revokeObjectURL(url);
                    }, 100);

                }).catch(function (error) {
                    console.error(error);
                });
            });

            function handleSourceOpen(event) {
            sourceBuffer = mediaSource.addSourceBuffer('video/webm; codecs="vp8"');
            }

            function handleDataAvailable(event) {
            if (event.data && event.data.size > 0) {
                recordedBlobs.push(event.data);
            }
            }

            function startRecording() {
            recordedBlobs = [];
            let options = {mimeType: 'video/webm;codecs=vp9'};
            if (!MediaRecorder.isTypeSupported(options.mimeType)) {
                options = {mimeType: 'video/webm;codecs=vp8'};
                if (!MediaRecorder.isTypeSupported(options.mimeType)) {
                options = {mimeType: 'video/webm'};
                if (!MediaRecorder.isTypeSupported(options.mimeType)) {
                    options = {mimeType: ''};
                }
                }
            }

            try {
                mediaRecorder = new MediaRecorder(window.stream, options);
            } catch (e) {
                return;
            }

            console.log('Created MediaRecorder', mediaRecorder, 'with options', options);
            recordButton.textContent = 'PARAR GRABACIÓN';
            playButton.disabled = true;
            downloadButton.disabled = true;
            mediaRecorder.ondataavailable = handleDataAvailable;
            mediaRecorder.start(10); // collect 10ms of data
            console.log('MediaRecorder started', mediaRecorder);
            }

            function stopRecording() {
                mediaRecorder.stop();
            }

            function handleSuccess(stream) {
                recordButton.disabled = false;
                window.stream = stream;

                const gumVideo = document.querySelector('video#gum');
                gumVideo.srcObject = stream;
            }

            async function init(constraints) {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia(constraints);
                    handleSuccess(stream);
                } catch (e) {
                   retun;
                }
            }

            document.querySelector('button#start').addEventListener('click', async () => {
                const constraints = {
                    video: {
                    width: 1280, height: 720
                    }
                };
                await init(constraints);
            });
        }
    }
</script>



<style>
    .plomo {
        color: #a0a0a0;
    }

    .alert{
        padding: 10px;
    };
</style>