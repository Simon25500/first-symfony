
import anime from "animejs";

const animeForm = () => {
    const form = document.querySelector('#contact-form');
    if (form.style.display === 'none') {

        anime({
            targets: '#contact-form',
            height: '280',
            opacity: '1',
            duration: 1000,
            easing: 'easeInOutQuad',
            begin: function () {
                form.style.display = 'block';
            },
        });
    } else {
        anime({

            targets: '#contact-form',
            height: '0',
            opacity: '0',
            duration: 1000,
            easing: 'easeInOutQuad',
            complete: function() {
                form.style.display = 'none';
            },
        });
    }
}

export default animeForm;