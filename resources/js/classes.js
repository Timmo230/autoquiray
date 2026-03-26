async function reservesClass(idClass){
    const post = await fetch('/classes', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            idClass: idClass,
        })
    });

    if(post.ok) window.location.href = `/classes`;
    else alert('Error al reservar clase');
}