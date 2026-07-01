<link rel="stylesheet" href="<?php echo e(asset('css/ai-bg.css')); ?>">

<div id="ai-bg">
    <canvas id="cBg"></canvas>
    <canvas id="cNet"></canvas>
    <canvas id="cFx"></canvas>
</div>

<div id="hud">
    <div class="hp" id="ht">
        <div class="logo"><span class="d"></span>AI_OS · v7.0</div>
        <div>SYS&nbsp;&nbsp;<span class="v" id="hSt">ACTIVE</span></div>
        <div>SIG&nbsp;&nbsp;<span class="v" id="hSg">0</span></div>
        <div>NOD&nbsp;&nbsp;<span class="v" id="hNd">0</span></div>
        <div>UP&nbsp;&nbsp;&nbsp;<span class="v" id="hUp">00:00</span></div>
    </div>
    <div class="hp" id="hr">
        <div>GRID&nbsp;<span class="v" id="hGr">--</span></div>
        <div>LOAD&nbsp;<span class="v" id="hLd">--</span>%</div>
        <div>CORES&nbsp;<span class="v" id="hCo">--</span></div>
        <div>ENC&nbsp;&nbsp;<span class="v">AES-256</span></div>
    </div>
    <div class="hp" id="hb">
        <div>◈ IOT CONTROL CENTER</div>
        <div>PING <span id="hPi">--</span>ms</div>
    </div>
    <div class="hp" id="hbr">
        <div><span class="v" id="hBr">□□□□□□□□</span></div>
        <div>192.168.0.1</div>
    </div>
</div>

<script src="<?php echo e(asset('js/ai-bg.js')); ?>"></script>
<?php /**PATH D:\PROJECT\LARAVEL\BUDI\resources\views/layouts/ai-bg.blade.php ENDPATH**/ ?>