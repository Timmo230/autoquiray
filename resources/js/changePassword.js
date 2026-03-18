const passwd = document.getElementById("new_password");
const repeatPasswd = document.getElementById("new_password_confirmation");
const form = document.getElementById("form");

let email = null;

form.addEventListener('submit', function (e) {
    e.preventDefault();
    if(checkPasswd()) login();
});


function checkPasswd(){
    if(passwd.value == repeatPasswd.value) return true;

    alert("Las contraseñas no coinciden");
    return false;
}

async function login(){
    const post = await fetch('/autoquiray/cambiar_contraseña', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            email: email,
            password: passwd.value
        })
    });

    if (post.ok) {
        window.location.href = '/autoquiray/login';
        return;
    }

    let errorText = 'Error al guardar la contraseña';

    try {
        const errorJson = await post.json();
        if (errorJson.message) {
            errorText = errorJson.message;
        }
    } catch (_) {}

    alert(errorText);
}