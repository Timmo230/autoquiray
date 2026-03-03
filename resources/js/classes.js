async function reservesClass(idClass){
    const post = await fetch('/autoquiray/classes', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            idClass: idClass,
        })
    });

    if(post.ok) window.location.href = `/autoquiray/classes`;
    else alert('Error al reservar clase');
}