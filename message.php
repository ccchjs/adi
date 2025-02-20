<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Message Page</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    /* Basic body styles */
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: palevioletred;
      overflow: hidden;
      position: relative;
      flex-direction: column;
    }

    /* Back Arrow Styles */
    .back-arrow {
      position: absolute;
      top: 20px;
      left: 20px;
      font-size: 24px;
      color: #ffffff;
      text-decoration: none;
      padding: 10px;
      background-color: rgba(0, 0, 0, 0.5);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .back-arrow:hover {
      background-color: rgba(0, 0, 0, 0.7);
    }

    .back-arrow::before {
      content: "←";
      font-size: 28px;
    }

    /* Right Arrow Styles */
    .next-arrow {
      position: absolute;
      top: 20px;
      right: 20px;
      font-size: 24px;
      color: #ffffff;
      text-decoration: none;
      padding: 10px;
      background-color: rgba(0, 0, 0, 0.5);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: transform 0.3s ease;
    }

    .next-arrow:hover {
      background-color: rgba(0, 0, 0, 0.7);
      transform: scale(1.1);
    }

    .next-arrow::before {
      content: "→";
      font-size: 28px;
    }

    /* Background with animated hearts */
    .heart {
      position: absolute;
      animation: floatHearts 10s infinite, fadeOutHearts 5s forwards;
      pointer-events: none;
      font-size: 30px;
    }

    .heart::before {
      content: "❤️";
    }

    /* Make hearts float from all directions */
    @keyframes floatHearts {
      0% {
        transform: translate(0, 0) scale(1);
        opacity: 1;
      }
      50% {
        transform: translate(300px, -300px) scale(1.5);
        opacity: 0.7;
      }
      100% {
        transform: translate(-300px, -600px) scale(1);
        opacity: 0;
      }
    }

    /* Fade-out effect for hearts */
    @keyframes fadeOutHearts {
      0% {
        opacity: 1;
      }
      100% {
        opacity: 0;
      }
    }

    /* Styling for the message container */
    .message-container {
      background-color: #ffffff;
      padding: 40px 30px;
      border-radius: 15px;
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
      text-align: center;
      max-width: 400px;
      width: 100%;
      transform: scale(0);
      opacity: 0;
      animation: fadeInBounce 1s ease-out forwards;
    }

    /* Header styling */
    h1 {
      font-size: 36px;
      color: #4a90e2;
      margin-bottom: 20px;
    }

    /* Paragraph styling */
    p {
      font-size: 18px;
      color: #333;
      line-height: 1.6;
    }

    /* Bounce and fade-in animation for the container */
    @keyframes fadeInBounce {
      0% {
        transform: scale(0);
        opacity: 0;
      }
      60% {
        transform: scale(1.1);
        opacity: 1;
      }
      100% {
        transform: scale(1);
        opacity: 1;
      }
    }

    /* Button styling */
    .show-more-btn {
      background-color: #4a90e2;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      margin-top: 20px;
    }

    .show-more-btn:hover {
      background-color: #357ab7;
    }

    /* Flip page animation */
    .flip-page {
      animation: flip 1s ease-in-out forwards;
    }

    @keyframes flip {
      0% {
        transform: rotateY(0deg);
      }
      100% {
        transform: rotateY(180deg);
      }
    }
  </style>
</head>
<body>
  <!-- Back Arrow -->
  <a href="dashboard.html" class="back-arrow"></a>

  <div class="message-container">
    <h1>For My adi 💖</h1>
    <p>Every moment with you is a treasure. You bring so much joy into my life, and I feel lucky to share this journey with you. I love you more than words can express, and I can't wait for all the beautiful memories we will create together. You are my adi forever. ❤️</p>
    <button class="show-more-btn" onclick="showMoreHearts()">Show More Hearts</button>
  </div>

  <!-- Right Arrow -->
  <a href="photo.php" class="next-arrow" id="next-arrow"></a>

  <!-- Heart elements to float in the background -->
  <div class="heart"></div>
  <div class="heart"></div>
  <div class="heart"></div>
  <div class="heart"></div>
  <div class="heart"></div>
  <div class="heart"></div>
  <div class="heart"></div>
  <div class="heart"></div>
  <div class="heart"></div>
  <div class="heart"></div>

  <script>
    // Show more hearts
    function showMoreHearts() {
      const body = document.body;
      for (let i = 0; i < 5; i++) {
        const heart = document.createElement('div');
        heart.classList.add('heart');

        const randomTop = Math.floor(Math.random() * 100) + '%';
        const randomLeft = Math.floor(Math.random() * 100) + '%';
        const randomDuration = Math.floor(Math.random() * (30 - 10 + 1)) + 10 + 's';
        const randomDelay = Math.floor(Math.random() * 10) + 's';

        heart.style.top = randomTop;
        heart.style.left = randomLeft;
        heart.style.animationDuration = randomDuration;
        heart.style.animationDelay = randomDelay;

        body.appendChild(heart);

        heart.addEventListener('animationend', () => {
          heart.remove();
        });
      }
    }

    // Add flip page effect on next arrow click
    document.querySelector('.next-arrow').addEventListener('click', function(event) {
      event.preventDefault();
      document.body.classList.add('flip-page');
      setTimeout(function() {
        window.location.href = 'photo.php';
      }, 1000); // Wait for the flip effect to finish before navigating
    });
  </script>
</body>
</html>
