const indexFormInputs = document.querySelectorAll(".form-control");
const indexFormSubmit = document.querySelector("#formFight");
const indexSubmitBtn = document.querySelector("#fight");
console.log(indexFormInputs);
console.log(indexFormSubmit);
console.log(indexSubmitBtn);
player1Selector = document.querySelector("#player1selector");
player2Selector = document.querySelector("#player2selector");
player1SelectorOptions = document.querySelector("#player1selector").options;
player2SelectorOptions = document.querySelector("#player2selector").options;
console.log(player1SelectorOptions.value);


function hideOptions (selector1, selector2) {  
selector1.addEventListener("blur", (event) => {
  if (selector1.value != "") {
    console.log("value selected");
    removedValue = selector1.value;
    for (let i = 0; i < selector2.length; i++) {
      if (selector2[i].value == removedValue) {
        console.log("match" + selector2[i].value);
        selector2[i].disabled = true;
      } else {
        selector2[i].disabled = false;
      }
    }
  }
});
selector2.addEventListener("blur", (event) => {
  if (selector2.value != "") {
    console.log("value selected");
    removedValue = selector2.value;
    for (let i = 0; i < selector1.length; i++) {
      if (selector1[i].value == removedValue) {
        console.log("match" + selector1[i].value);
        selector1[i].disabled = true;
      } else {
        selector1[i].disabled = false;
      }
    }
  }
})
};

hideOptions(player1Selector, player2Selector)


// player2Selector = document.querySelector("#player2selector");
// player1Selector.addEventListener("blur", (event) => {
//   if (player1Selector.value != "") {
//     console.log("value selected");
//     removedValue = player1Selector.value;
//     for (let i = 0; i < player2SelectorOptions.length; i++) {
//       if (player2SelectorOptions[i].value == removedValue) {
//         console.log("match" + player2SelectorOptions[i].value);
//         player2SelectorOptions[i].disabled = true;
//       } else {
//         player2SelectorOptions[i].disabled = false;
//       }
//     }
//   }
// });

indexFormSubmit.addEventListener("submit", (event) => {
  event.preventDefault();
  let errorCounter = 0;
  for (let i = 0; i < indexFormInputs.length; i++) {
    if (indexFormInputs[i].value === "") {
      console.log("vide");
      indexFormInputs[i].classList.add("is-invalid");
      errorCounter++;
    } else {
      indexFormInputs[i].classList.add("is-valid");
    }
    if (errorCounter === 0) {
      indexSubmitBtn.classList.add("animate__animated");
      indexSubmitBtn.classList.add("animate__rubberBand");
      setTimeout(function () {
        indexSubmitBtn.classList.remove("animate__rubberBand");
      }, 1000);
      let fight_song = document.getElementById("fight-song");
      fight_song.play();
      setTimeout(function () {
        indexFormSubmit.submit();
      }, 500);
    }
  }
});
