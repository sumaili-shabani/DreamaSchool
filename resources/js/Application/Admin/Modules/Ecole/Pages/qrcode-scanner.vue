<template>
    <div>

        <div id="qr-code-full-region"></div>

    </div>
</template>
<!-- <script src="https://unpkg.com/html5-qrcode"></script> -->
<script>
// To use Html5QrcodeScanner (more info below)
import {Html5QrcodeScanner} from "html5-qrcode";
// To use Html5Qrcode (more info below)
import {Html5Qrcode} from "html5-qrcode";
export default {
    props: {
        qrbox: {
            type: Number,
            default: 250
        },
        fps: {
            type: Number,
            default: 10
        },
    },

    mounted() {
        const config = {
            fps: this.fps,
            qrbox: this.qrbox,
        };
        const html5QrcodeScanner = new Html5QrcodeScanner('qr-code-full-region', config);
        html5QrcodeScanner.render(this.onScanSuccess);
    },
    methods: {
        onScanSuccess(decodedText, decodedResult) {
            this.$emit('result', decodedText, decodedResult);
        }
    }
}
</script>
