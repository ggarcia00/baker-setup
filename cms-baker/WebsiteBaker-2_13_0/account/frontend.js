    document.addEventListener("DOMContentLoaded", function () {
        let fieldsreset = document.querySelector('.start_reset');
        fieldsreset.addEventListener (
            "click",
            function (evt) {
                let url = window.location.protocol +'//'+ window.location.host + window.location.pathname;
                window.location.href = url;
                evt.preventDefault();
        });
    });
