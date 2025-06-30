document.addEventListener("DOMContentLoaded", function () {
    let rotation1 = 0;
    let rotation2 = 0;
    const rotasiInput1 = document.getElementById("rotasi1");
    const rotasiInput2 = document.getElementById("rotasi2");
    const imgRotate1 = document.getElementById("img-rotate1");
    const imgRotate2 = document.getElementById("img-rotate2");
    const btnLeft = document.getElementById("rotasi-kiri");
    const btnRight = document.getElementById("rotasi-kanan");
    fetch("/get-random-images")
        .then(response => response.json())
        .then(data => {
            imgRotate1.src = data.image1;
            imgRotate2.src = data.image2;
            rotation1 = data.rotation1;
            rotation2 = data.rotation2;
            rotasiInput1.value = rotation1;
            rotasiInput2.value = rotation2;
            imgRotate1.style.transform = `rotate(${rotation1}deg)`;
            imgRotate2.style.transform = `rotate(${rotation2}deg)`;
        })
        .catch(error => console.error("Error fetching images:", error));
    btnLeft.addEventListener("click", function () {
        rotation2 = (rotation2 - 45 + 360) % 360;
        imgRotate1.style.transform = `rotate(${rotation1}deg)`;
        imgRotate2.style.transform = `rotate(${rotation2}deg)`;
        rotasiInput1.value = rotation1;
        rotasiInput2.value = rotation2;
    });
    btnRight.addEventListener("click", function () {
        rotation2 = (rotation2 + 45) % 360;
        imgRotate1.style.transform = `rotate(${rotation1}deg)`;
        imgRotate2.style.transform = `rotate(${rotation2}deg)`;
        rotasiInput1.value = rotation1;
        rotasiInput2.value = rotation2;
    });
});


document.addEventListener('DOMContentLoaded', () => {
    const captchaForm = document.getElementById('captcha-form');
    const captchaForm1 = document.getElementById('captcha-form1');
    function showCaptcha(type) {
        if (type === 'captcha1') {
            captchaForm?.classList.add('hidden');
            captchaForm1?.classList.remove('hidden');
        } else {
            captchaForm?.classList.remove('hidden');
            captchaForm1?.classList.add('hidden');
        }
    }
    const formToShow = document.body.getAttribute('data-show-form');
    if (formToShow === 'captcha' || formToShow === 'captcha1') {
        showCaptcha(formToShow);
    }
    window.showCaptcha = showCaptcha;
});
