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
player1Name = document.querySelector('#player-name');
player1Attaque = document.querySelector('#player-attaque');
player1Mana = document.querySelector('#player-mana');
player1Sante = document.querySelector('#player-sante');
adversaireName = document.querySelector('#adversaire-name');
adversaireAttaque = document.querySelector('#adversaire-attaque');
adversaireMana = document.querySelector('#adversaire-mana');
adversaireSante = document.querySelector('#adversaire-sante');
console.log(adversaireName);


function hideOptions (selector1, selector2) {  
selector1.addEventListener("blur", (event) => {
  if (selector1.value != "") {
    player1Name.disabled = true;
    player1Name.required = false;
    player1Attaque.disabled = true;
    player1Attaque.required = false;
    player1Mana.disabled = true;
    player1Mana.required = false;
    player1Sante.disabled = true;
    player1Sante.required = false;
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
  } else {
    player1Name.disabled = false;
    player1Name.required = true;
    player1Attaque.disabled = false;
    player1Attaque.required = true;
    player1Mana.disabled = false;
    player1Mana.required = true;
    player1Sante.required = true;
    for (let i = 0; i < selector2.length; i++) {
      
        selector2[i].disabled = false;
      }
  }
});
selector2.addEventListener("blur", (event) => {
  if (selector2.value != "") {
     adversaireName.disabled = true;
     adversaireName.required = false;
    adversaireAttaque.disabled = true;
    adversaireAttaque.required = false;
    adversaireMana.disabled = true;
    adversaireMana.required = false;
    adversaireSante.disabled = true;
    adversaireSante.required = false;
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
  } else {
     adversaireName.disabled = false;
     adversaireName.required = true;
    adversaireAttaque.disabled = false;
    adversaireAttaque.required = true;
    adversaireMana.disabled = false;
    adversaireMana.required = true;
    adversaireSante.disabled = false;
    adversaireSante.required = true;
    for (let i = 0; i < selector1.length; i++) {
      
        selector1[i].disabled = false;
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
  let errorCounter = 0;
  for (let i = 0; i < indexFormInputs.length; i++) {
    if (indexFormInputs[i].value === "" && indexFormInputs[i].required === true) {
      event.preventDefault();
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
