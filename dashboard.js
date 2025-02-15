// Your start date, example: "2024-12-10" (YYYY-MM-DD)
const startDate = new Date("2024-12-10");

function updateMonthsTogether() {
  const today = new Date();
  
  // Calculate the difference in months
  const monthsDifference = (today.getFullYear() - startDate.getFullYear()) * 12 + today.getMonth() - startDate.getMonth();
  
  // If the 16th day has passed this month, increase by 1 month
  if (today.getDate() >= 16) {
    document.getElementById("months").textContent = monthsDifference + 1; // Add 1 month if the 16th has passed
  } else {
    document.getElementById("months").textContent = monthsDifference;
  }

  updateCountdown();
}

function updateCountdown() {
  const today = new Date();
  const nextAnniversary = new Date(today.getFullYear(), today.getMonth(), 16);
  
  // If the 16th has already passed this month, set the next anniversary to next month's 16th
  if (today.getDate() > 16) {
    nextAnniversary.setMonth(nextAnniversary.getMonth() + 1);
  }

  const timeDiff = nextAnniversary - today;
  const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
  const hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
  const seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);

  document.getElementById("next-anniversary").textContent = `${days} , ${hours} , ${minutes} , ${seconds} `;

  // Update every second to keep the countdown fresh
  setInterval(updateCountdown, 1000);
}

// Initialize the months and countdown when the page loads
updateMonthsTogether();
