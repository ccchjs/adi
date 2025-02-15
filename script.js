let enteredPasscode = "";

function appendNumber(number) {
  enteredPasscode += number;
  document.getElementById("display").textContent = enteredPasscode;
  checkPasscode(); // Check passcode after each number entered
}

function clearDisplay() {
  enteredPasscode = "";
  document.getElementById("display").textContent = "";
}

function checkPasscode() {
  const correctPasscode = "111624";
  const message = document.getElementById("message");

  if (enteredPasscode === correctPasscode) {
    // Show success message and simulate redirect to the dashboard
    message.textContent = "Access Granted!";
    message.style.color = "green";

    setTimeout(() => {
      window.location.href = "dashboard.html"; // Simulating a redirect to a dashboard page
    }, 2000); // 2 seconds delay before redirecting
  } else {
    message.textContent = "";
  }
}
