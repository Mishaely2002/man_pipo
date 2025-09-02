function typeWelcomeMessage(targetId = "dynamicWelcome") {
  const message = "Welcome to Mwansele High School";
  const target = document.getElementById(targetId);
  if (!target) return;

  target.innerHTML = "";
  let index = 0;

  const typeLetter = () => {
    if (index < message.length) {
      target.innerHTML += message.charAt(index);
      index++;
      setTimeout(typeLetter, 80); // Adjust speed here
    }
  };

  typeLetter();
}

document.addEventListener("DOMContentLoaded", function () {
  typeWelcomeMessage();
});
