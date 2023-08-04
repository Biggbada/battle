function hideOptions (selector1, selector2)
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