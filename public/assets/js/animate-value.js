function animateValue(element, start, end, duration = 400) {
    if(element.animationId){
        cancelAnimationFrame(element.animationId)
    }
    const current_text  = start;
    const start_value = parseInt(current_text, 10); // 100
    const end_value = end; //300
    let startTime = null;

    const animate = (currentTime) =>{
        
        if(!startTime){
            startTime = currentTime
        }

        const progress = Math.min((currentTime - startTime) / duration, 1)
        
        const current_value = Math.floor(progress * (end_value - start_value) + start_value)

        element.textContent = current_value
        if(progress != 1){
            requestAnimationFrame(animate)
        }else{
            element.textContent = end_value
        }
    }

    element.animationId = requestAnimationFrame(animate)
}