function getTimeBasedGreeting() {
  const now = new Date();
  const hour = now.getHours();
  const day = now.getDay();

  if (day === 0) return "🛌 It’s Sunday—rest well! Want to prep for the week ahead?";
  if (day === 5) return "🎉 Happy Friday! Want to check weekend events or club meetups?";
  if (hour < 12) return "🌞 Good morning! Ready for today’s schedule?";
  if (hour < 17) return "🌤️ Good afternoon! Want to check your classes or events?";
  return "🌙 Good evening! Need help reviewing today’s progress?";
}

function injectGreeting(targetId = "assistantGreeting") {
  const greeting = getTimeBasedGreeting();
  const target = document.getElementById(targetId);
  if (!target) return;

  target.innerHTML = ""; // Clear existing content
  let index = 0;

  const typeLetter = () => {
    if (index < greeting.length) {
      target.innerHTML += greeting.charAt(index);
      index++;
      setTimeout(typeLetter, 40); // Speed of typing (adjust as needed)
    }
  };

  typeLetter();
}
