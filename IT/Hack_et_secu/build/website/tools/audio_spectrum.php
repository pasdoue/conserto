

<!-- <div id="spectrogram">
    
    <canvas id="canvas" style="width: 100%; height:50%;"></canvas>

        <p id="controls">
          <input type="button" id="start_button" value="Start">
          &nbsp; &nbsp;
          <input type="button" id="stop_button" value="Stop">
          <p id="msg"></p>
        </p>
</div> -->

<div class="col-md-10" style="margin-top: 4%;">

    <div class="row">
        <div class="col-md-12" >
            <canvas id="canvas" style="width: 100%; height:50%;" ></canvas>

            <p id="controls">
                <input type="button" id="start_button" value="Start">
                &nbsp; &nbsp;
                <input type="button" id="stop_button" value="Stop">
                <p id="msg"></p>

            </p>

            <p>
                <label for="freq_echantillonage">Frequence echantillonage</label>
                <select id="freq_echantillonage" class="form-control">
                    <option value="1024" selected="true">1024</option>
                    <option value="256">256</option>
                    <option value="512">512</option>
                    <option value="2048">2048</option>
                    <option value="4096">4096</option>
                </select>

            </p>


        </div>
    </div>
</div>



<script type="text/javascript">

/*const spectrum = new Uint8Array(analyser.frequencyBinCount)
;(function updateSpectrum() {
  requestAnimationFrame(updateSpectrum)
  analyser.getByteFrequencyData(spectrum)
})()


const spectroCanvas = document.getElementById('spectrogram')
spectroCanvas.width = spectrum.length
spectroCanvas.height = 200
const spectroContext = spectroCanvas.getContext('2d')
let spectroOffset = 0

;(function drawSpectrogram() {
  requestAnimationFrame(drawSpectrogram)
  const slice = spectroContext.getImageData(0, spectroOffset, spectroCanvas.width, 1)
  for (let i = 0; i < spectrum.length; i++) {
    slice.data[4 * i + 0] = spectrum[i] // R
    slice.data[4 * i + 1] = spectrum[i] // G
    slice.data[4 * i + 2] = spectrum[i] // B
    slice.data[4 * i + 3] = 255         // A
  }
  spectroContext.putImageData(slice, 0, spectroOffset)
  spectroOffset += 1
  spectroOffset %= spectroCanvas.height
})()*/




let audioBuffer;
let sourceNode;
let analyserNode;
let javascriptNode;
let audioData = null;
let audioPlaying = false;
let sampleSize = 1024;  // number of samples to collect before analyzing data
let frequencyDataArray;     // array to hold time domain data
// Global Variables for the Graphics
var canvas = document.getElementById('canvas');
/*let canvasWidth = 512;
let canvasHeight = 256;*/
var canvasWidth = canvas.width;
var canvasHeight = canvas.height;
let ctx;

document.addEventListener("DOMContentLoaded", function () {
    ctx = document.body.querySelector('canvas').getContext("2d");
    // the AudioContext is the primary 'container' for all your audio node objects
    try {
        audioContext = new AudioContext();
    } catch (e) {
        alert('Web Audio API is not supported in this browser');
    }
    // When the Start button is clicked, finish setting up the audio nodes, play the sound,
    // gather samples for the analysis, update the canvas
    document.body.querySelector('#start_button').addEventListener('click', function (e) {
        e.preventDefault();
        // Set up the audio Analyser, the Source Buffer and javascriptNode
        initCanvas();
        setupAudioNodes();
        javascriptNode.onaudioprocess = function () {
            // get the Time Domain data for this sample
            analyserNode.getByteFrequencyData(frequencyDataArray);
            // draw the display if the audio is playing
            //console.log(frequencyDataArray)
            draw();
        };
        loadSound();
    });

    document.body.querySelector("#stop_button").addEventListener('click', function(e) {
        e.preventDefault();
        sourceNode.stop(0);
        audioPlaying = false;
    });

    function loadSound() {
        music_file = 'http://127.0.0.1:8080/edsa-conserto_challenges/challs/steganographie/horrible_consert(o).wav';
        //music_file = 'http://127.0.0.1:8080/edsa-conserto_challenges/challs/steganographie/test.m4a';
        fetch(music_file).then(response => {
            response.arrayBuffer().then(function (buffer) {
                audioContext.decodeAudioData(buffer).then((audioBuffer) => {
                    //console.log('audioBuffer', audioBuffer);
                    // {length: 1536000, duration: 32, sampleRate: 48000, numberOfChannels: 2}
                    audioData = audioBuffer;
                    playSound(audioBuffer);
                });
            });
        })
    }

    function setupAudioNodes() {
        sourceNode = audioContext.createBufferSource();
        analyserNode = audioContext.createAnalyser();
        analyserNode.fftSize = document.getElementById("freq_echantillonage").value;
        javascriptNode = audioContext.createScriptProcessor(sampleSize, 1, 1);
        // Create the array for the data values
        frequencyDataArray = new Uint8Array(analyserNode.frequencyBinCount);
        // Now connect the nodes together
        sourceNode.connect(audioContext.destination);
        sourceNode.connect(analyserNode);
        analyserNode.connect(javascriptNode);
        javascriptNode.connect(audioContext.destination);
    }

    function initCanvas() {
        //create purple canvas 
        ctx.fillStyle = 'hsl(280, 100%, 10%)';
        ctx.fillRect(0, 0, canvasWidth, canvasHeight);
    };

    // Play the audio once
    function playSound(buffer) {
        sourceNode.buffer = buffer;
        sourceNode.start(0);    // Play the sound now
        sourceNode.loop = false;
        audioPlaying = true;
    }

    function draw() {
        const data = frequencyDataArray;
        const dataLength = frequencyDataArray.length;
        console.log("data", data);
        console.log("dataLength", dataLength);

        const h = canvasHeight / dataLength;
        //const h = canvasHeight;// / dataLength;
        // draw on the right edge
        const x = canvasWidth - 1;

        // copy the old image and move one left
        let imgData = ctx.getImageData(1, 0, canvasWidth - 1, canvasHeight);
        ctx.fillRect(0, 0, canvasWidth, canvasHeight);
        ctx.putImageData(imgData, 0, 0);

        for (let i = 0; i < dataLength; i++) {
            //console.log(data)
            let rat = data[i] / 255;
            console.log(rat)
            let hue = Math.round((rat * 120) + 280 % 360);
            let sat = '100%';
            let lit = 10 + (70 * rat) + '%';
            // console.log("rat %s, hue %s, lit %s", rat, hue, lit);
            ctx.beginPath();
            ctx.strokeStyle = `hsl(${hue}, ${sat}, ${lit})`;
            ctx.moveTo(x, canvasHeight - (i * h));
            ctx.lineTo(x, canvasHeight - (i * h + h));
            ctx.stroke();
        }
    }
});



</script>