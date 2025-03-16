const toggler = document.querySelector(".toggler-btn");
toggler.addEventListener("click", function(){
    document.querySelector("#sidebar").classList.toggle("collapsed");
})


function setStarRating(StarIndex) {
   const stars = document.querySelectorAll('input[type="radio"]');
   const labels = document.querySelectorAll('label');

   
   stars.forEach((star, index) => {
     star.addEventListener('click', () => {
       labels.forEach((label, labelIndex) => {
         label.style.fill = labelIndex <= index ? '#fd4' : '#444';
       });
     });
   });

   
   labels.forEach((label, index) => {
     label.style.fill = index < StarIndex ? '#fd4' : '#444';
   });
 }

 setStarRating();
