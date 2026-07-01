<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pameran TKI - SMKN 1 Subang</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/welcome.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/ai-bg.css')); ?>">
    <style>
        #bgWrap {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: 0;
            background: radial-gradient(ellipse at 45% 0%, #0b3060 0%, #041a30 40%, #010e1e 75%, #000508 100%);
        }
        #bgCanvas {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
        }
    </style>

</head>
<body>

    <!-- Success Alert -->
    <?php if(session('success')): ?>
    <div id="successAlert" style="
        position: fixed;
        top: 80px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(0,0,0,0.75);
        color: #FFB800;
        padding: 14px 32px;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        z-index: 999;
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255,184,0,0.4);
    ">✓ <?php echo e(session('success')); ?></div>
    <script>
        setTimeout(() => {
            document.getElementById('successAlert').style.display = 'none';
        }, 4000);
    </script>
    <?php endif; ?>

    <!-- Background -->
    <div id="bgWrap"><canvas id="bgCanvas"></canvas></div>

    <!-- Navbar -->
    <nav>
        <div class="nav-left">
            <img src="<?php echo e(asset('img/Gambar_SMKN_1SUBANG.png')); ?>" alt="Logo Nesasa" class="nav-logo">
            <span class="nav-title">PAMERAN TKI</span>
        </div>
        <a href="/login" class="btn-login">Login Admin</a>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <h1 class="welcome-text">
            <span class="line1">Selamat Datang di</span>
            <span class="line2">Pameran TKI</span>
        </h1>

        <div class="logo-section">
            <img src="<?php echo e(asset('img/LOGO RPL.png')); ?>" alt="Logo RPL" class="logo-school">
            <span class="x-separator">✕</span>
            <img src="<?php echo e(asset('img/LogoTKJ.png')); ?>" alt="Logo TKJ" class="logo-school">
        </div>

        <a href="/guest-form" class="btn-isi-data">Isi Data Tamu</a>
    </div>

    <!-- Footer -->
    <footer>
        © 2024 PAMERAN TKI - SMKN 1 SUBANG
    </footer>

    <script>
    (function(){
        const cv = document.getElementById('bgCanvas');
        const wp = document.getElementById('bgWrap');
        const ct = cv.getContext('2d');
        let W, H;

        const MAX_STRANDS = 45;
        const strands = [];

        function rnd(a,b){ return a + Math.random()*(b-a); }
        function clamp(v,a,b){ return Math.max(a,Math.min(b,v)); }

        let stars = [];
        function buildStars(){
            stars = [];
            for(let i=0;i<90;i++){
                stars.push({ x:rnd(0,W), y:rnd(0,H), r:rnd(0.3,1.1), a:rnd(0.05,0.28), phase:rnd(0,Math.PI*2), spd:rnd(0.002,0.006) });
            }
        }

        function buildStrand(){
            const x = rnd(20, W-20);
            const segs = [];
            let cy = 0, curX = x;
            const totalH = rnd(H*0.35, H*0.82);
            while(cy < totalH){
                const vLen = rnd(50,130);
                const end = Math.min(cy+vLen, totalH);
                segs.push({x1:curX, y1:cy, x2:curX, y2:end});
                cy = end;
                if(cy >= totalH) break;
                const shift = rnd(20,60)*(Math.random()<0.5?1:-1);
                const nx = clamp(curX+shift, 20, W-20);
                if(Math.abs(nx-curX) > 10){ segs.push({x1:curX, y1:cy, x2:nx, y2:cy}); curX = nx; }
            }
            const g = Math.random();
            return {
                segs, tipX:curX, tipY:totalH,
                phase:'draw', drawProgress:0, drawSpeed:rnd(0.002,0.005),
                holdTimer:0, holdDuration:rnd(120,240),
                fadeAlpha:1, fadeSpeed:rnd(0.005,0.010),
                baseAlpha:rnd(0.35,0.65),
                isSuper:g<0.08, isGlow:g<0.25,
                nodeR:rnd(3.5,5.5), pulse:rnd(0,Math.PI*2), pulseSpd:rnd(0.005,0.015),
                flowT:0, flowSpd:rnd(0.003,0.006), dead:false
            };
        }

        function totalLen(segs){ return segs.reduce((s,g)=>s+Math.hypot(g.x2-g.x1,g.y2-g.y1),0); }
        function ptAt(segs,t){
            const tot = totalLen(segs); let d = t*tot;
            for(const s of segs){
                const l = Math.hypot(s.x2-s.x1,s.y2-s.y1);
                if(d<=l){ const p=l?d/l:0; return {x:s.x1+(s.x2-s.x1)*p, y:s.y1+(s.y2-s.y1)*p}; }
                d -= l;
            }
            return {x:segs[segs.length-1].x2, y:segs[segs.length-1].y2};
        }

        let spawnCooldown = 0;
        function spawnIfNeeded(){
            spawnCooldown--;
            const active = strands.filter(s=>!s.dead).length;
            if(active < MAX_STRANDS && spawnCooldown <= 0){ strands.push(buildStrand()); spawnCooldown = rnd(3,10); }
            for(let i=strands.length-1;i>=0;i--){ if(strands[i].dead) strands.splice(i,1); }
        }

        function glowDot(x,y,r,color,blur,alpha){
            ct.save(); ct.shadowColor=color; ct.shadowBlur=blur; ct.globalAlpha=alpha;
            ct.fillStyle=color; ct.beginPath(); ct.arc(x,y,r,0,Math.PI*2); ct.fill(); ct.restore();
        }

        function drawStrand(s){
            s.pulse += s.pulseSpd;
            const bright = 0.6 + 0.4*Math.sin(s.pulse);
            const masterAlpha = s.fadeAlpha;

            if(s.phase==='draw'){ s.drawProgress=Math.min(1,s.drawProgress+s.drawSpeed); if(s.drawProgress>=1) s.phase='hold'; }
            else if(s.phase==='hold'){ s.holdTimer++; if(s.holdTimer>=s.holdDuration) s.phase='fade'; }
            else if(s.phase==='fade'){ s.fadeAlpha-=s.fadeSpeed; if(s.fadeAlpha<=0){ s.dead=true; return; } }

            const clipY = s.tipY * s.drawProgress;
            ct.save(); ct.beginPath(); ct.rect(0,0,W,clipY); ct.clip();

            const la = s.baseAlpha * bright * masterAlpha;
            ct.save();
            if(s.isSuper){ ct.shadowColor='#00d8ff'; ct.shadowBlur=16; }
            else if(s.isGlow){ ct.shadowColor='#0088dd'; ct.shadowBlur=8; }
            ct.strokeStyle=`rgba(0,${s.isSuper?200:165},255,${la})`;
            ct.lineWidth=s.isSuper?1.3:0.85; ct.lineCap='round';
            ct.beginPath();
            s.segs.forEach((sg,i)=>{ if(i===0) ct.moveTo(sg.x1,sg.y1); ct.lineTo(sg.x2,sg.y2); });
            ct.stroke(); ct.restore();

            for(let i=1;i<s.segs.length;i++){
                const sg=s.segs[i];
                ct.save(); ct.shadowColor='#00bbff'; ct.shadowBlur=5;
                ct.fillStyle=`rgba(120,205,255,${la*0.8})`;
                ct.beginPath(); ct.arc(sg.x1,sg.y1,1.8,0,Math.PI*2); ct.fill(); ct.restore();
            }

            if(s.phase!=='fade'){
                s.flowT+=s.flowSpd; if(s.flowT>1) s.flowT=0;
                for(let t=1;t<=5;t++){
                    const tt=Math.max(0,s.flowT-t*0.02);
                    const tp=ptAt(s.segs,tt);
                    ct.globalAlpha=(1-t/6)*0.45*bright*masterAlpha;
                    ct.fillStyle='#00ccff';
                    ct.beginPath(); ct.arc(tp.x,tp.y,1.4-t*0.15,0,Math.PI*2); ct.fill(); ct.globalAlpha=1;
                }
                const bp=ptAt(s.segs,s.flowT);
                glowDot(bp.x,bp.y,2.5,'#00eeff',14,0.9*bright*masterAlpha);
                glowDot(bp.x,bp.y,1.2,'#ffffff',5,bright*masterAlpha);
            }

            if(s.drawProgress>=1){
                const ta=s.baseAlpha*bright*masterAlpha;
                if(s.isSuper){
                    [s.nodeR*6,s.nodeR*3.5].forEach((hr,i)=>{
                        const g=ct.createRadialGradient(s.tipX,s.tipY,0,s.tipX,s.tipY,hr);
                        g.addColorStop(0,`rgba(0,200,255,${ta*(i===0?0.1:0.22)})`); g.addColorStop(1,'rgba(0,0,0,0)');
                        ct.fillStyle=g; ct.beginPath(); ct.arc(s.tipX,s.tipY,hr,0,Math.PI*2); ct.fill();
                    });
                    glowDot(s.tipX,s.tipY,s.nodeR*1.5,'#00eeff',28,ta*0.9);
                    glowDot(s.tipX,s.tipY,s.nodeR*0.65,'#ffffff',10,ta);
                } else if(s.isGlow){
                    const g=ct.createRadialGradient(s.tipX,s.tipY,0,s.tipX,s.tipY,s.nodeR*4);
                    g.addColorStop(0,`rgba(0,170,255,${ta*0.5})`); g.addColorStop(1,'rgba(0,0,0,0)');
                    ct.fillStyle=g; ct.beginPath(); ct.arc(s.tipX,s.tipY,s.nodeR*4,0,Math.PI*2); ct.fill();
                    glowDot(s.tipX,s.tipY,s.nodeR,'#7dd8ff',14,ta);
                    glowDot(s.tipX,s.tipY,s.nodeR*0.5,'#cceeff',5,ta);
                } else {
                    ct.fillStyle=`rgba(95,180,255,${ta*0.75})`;
                    ct.beginPath(); ct.arc(s.tipX,s.tipY,s.nodeR*0.7,0,Math.PI*2); ct.fill();
                }
            }
            ct.restore();
        }

        function loop(){
            ct.clearRect(0,0,W,H);
            stars.forEach(s=>{
                s.phase+=s.spd;
                const a=s.a*(0.4+0.6*Math.sin(s.phase));
                ct.globalAlpha=a; ct.fillStyle='#a0ccff';
                ct.beginPath(); ct.arc(s.x,s.y,s.r,0,Math.PI*2); ct.fill(); ct.globalAlpha=1;
            });
            spawnIfNeeded();
            strands.forEach(s=>{ if(!s.dead) drawStrand(s); });
            requestAnimationFrame(loop);
        }

        function resize(){
            W = cv.width = wp.offsetWidth;
            H = cv.height = wp.offsetHeight;
            buildStars(); strands.length = 0;
        }

        resize();
        requestAnimationFrame(loop);
        let rt;
        window.addEventListener('resize',()=>{ clearTimeout(rt); rt=setTimeout(resize,150); });
    })();
    </script>

</body>
</html>
<?php /**PATH D:\PROJECT\LARAVEL\BUDI\resources\views/index.blade.php ENDPATH**/ ?>