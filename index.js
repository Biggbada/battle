const indexFormInputs = document.querySelectorAll(".form-control");
const indexFormSubmit = document.querySelector("#formFight");
const indexSubmitBtn = document.querySelector("#fight");
console.log(indexFormInputs);
console.log(indexFormSubmit);
console.log(indexSubmitBtn);

// indexFormSubmit.addEventListener("submit", (event) => {
//   event.preventDefault();
//   let errorCounter = 0;
//   for (let i = 0; i < indexFormInputs.length; i++) {
//     if (indexFormInputs[i].value === "") {
//       console.log("vide");
//       indexFormInputs[i].classList.add("is-invalid");
//       errorCounter++;
//     } else {
//       indexFormInputs[i].classList.add("is-valid");
//     }
//     if (errorCounter === 0) {
//       indexSubmitBtn.classList.add("animate__animated");
//       indexSubmitBtn.classList.add("animate__rubberBand");
//       setTimeout(function () {
//         indexSubmitBtn.classList.remove("animate__rubberBand");
//       }, 1000);
//       let fight_song = document.getElementById("fight-song");
//       fight_song.play();
//       setTimeout(function () {
//         indexFormSubmit.submit();
//       }, 500);
//     }
//   }
// });
