const technologies       = document.querySelectorAll('.technology');
const projects           = document.querySelectorAll('.container-technology-projects')
const screenshot         = document.getElementById('screenshot')
const methodology        = document.getElementById('methodology')
const selectScreenshot   = document.getElementById('screenshot-selector')
const selectMethodology  = document.getElementById('methodology-selector')

let index = 0;

technologies.forEach(technology => {
    technology.addEventListener('click', () => {
        if (technology.classList.contains('active')) {
            return;
        } else {
            technology.classList.toggle('active');
        }
        index = technology.getAttribute('data-show');

        showProjects(index)
    })
})

if (selectMethodology){
    selectMethodology.addEventListener('click', () => {
        selectMethodology.classList.add('active')
        selectScreenshot.classList.remove('active')
        methodology.classList.add('hide-show')
        screenshot.classList.remove('hide-show')
    })
}

if (selectMethodology) {
    selectScreenshot.addEventListener('click', () => {
        selectScreenshot.classList.add('active')
        selectMethodology.classList.remove('active')
        screenshot.classList.add('hide-show')
        methodology.classList.remove('hide-show')
    })
}

//slider-technologies//

    const slides = document.getElementsByClassName("technology-slide")
    const blockTechnologies = document.getElementById('slides')


    document.getElementById("btnback").addEventListener("click",() => {
        futureSlide(-1)
    })
    document.getElementById("btnnext").addEventListener("click",() => {
        futureSlide(1)
    })
    let slideindex = 1
    newSlide(slideindex)
    function futureSlide(n) {
        newSlide(slideindex += n)
    }
    function newSlide(n) {
        if (n < 1) {
            slideindex = 1

        }
        if (n > slides.length) {
            slideindex = slides.length
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
            slides[i].classList.remove('active')
        }
        slides[slideindex-1].classList.add('active')
        slides[slideindex-1].style.display = "block"
        let index = slides[slideindex-1].getAttribute('data-show')
        showProjects(index)
    }




function showProjects(index){
    for (i = 0; i < technologies.length; i++) {
        if (technologies[i].getAttribute('data-show') !== index) {
            technologies[i].classList.remove('active');
        }
    }
    for (j = 0; j < projects.length; j++) {
        if (projects[j].getAttribute('data-show') === index) {
            projects[j].classList.toggle('active-block')
        } else {
            projects[j].classList.remove('active-block')
        }
    }
}

