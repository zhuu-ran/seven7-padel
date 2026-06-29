document.addEventListener('DOMContentLoaded', () => {
    const slider = document.querySelector('.foto-slider');
    const dots = document.querySelectorAll('.dot');
    const modalLogin = document.getElementById('modalLogin');
    const modalRegister = document.getElementById('modalRegister');
    let current = 0;
    const total = dots.length;

    document.querySelector('.btn-sign').addEventListener('click', (e) => {
        e.preventDefault();
        modalLogin.classList.add('active');
    });

    document.querySelector('.btn-regist').addEventListener('click', (e) => {
        e.preventDefault();
        modalRegister.classList.add('active');
    });

    document.getElementById('closeLogin').addEventListener('click', () => {
        modalLogin.classList.remove('active');
    });

    document.getElementById('closeRegister').addEventListener('click', () => {
        modalRegister.classList.remove('active');
    });

    document.getElementById('toRegister').addEventListener('click', (e) => {
        e.preventDefault();
        modalLogin.classList.remove('active');
        modalRegister.classList.add('active');
    });

    document.getElementById('toLogin').addEventListener('click', (e) => {
        e.preventDefault();
        modalRegister.classList.remove('active');
        modalLogin.classList.add('active');
    });

    document.querySelectorAll('.modal-overlay').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.classList.remove('active');
        });
    });

    function goTo(index) {
        if (index >= total) index = 0;
        if (index < 0) index = total - 1;
        current = index;
        slider.scrollTo({ left: current * slider.offsetWidth, behavior: 'smooth' });
        dots.forEach(d => d.classList.remove('active'));
        dots[current].classList.add('active');
    }

    // Auto slide tiap 3 detik
    setInterval(() => goTo(current + 1), 3000);

    document.querySelector('.next').addEventListener('click', () => goTo(current + 1));
    document.querySelector('.prev').addEventListener('click', () => goTo(current - 1));
});

function togglePassword(inputId, icon) {
    const input = document.getElementById(inputId);
    const i = icon.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        i.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        i.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

function toggleSlot(id) {
    const slot = document.getElementById('slot-' + id);
    const badge = document.querySelector('[onclick="toggleSlot(' + id + ')"]');
    const icon = badge.querySelector('i');
    if (slot.style.display === 'none' || slot.style.display === '') {
        slot.style.display = 'flex';
        icon.classList.replace('fa-chevron-down', 'fa-chevron-up');
    } else {
        slot.style.display = 'none';
        icon.classList.replace('fa-chevron-up', 'fa-chevron-down');
    }
}