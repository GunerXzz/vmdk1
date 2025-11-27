document.addEventListener("DOMContentLoaded", function () {
  // --- 1. Data Setup ---
  // Store all testimonial data in a JavaScript array.
  const testimonialsData = [
    {
      name: "Johny Sins",
      image: "images/johny sins.png",
      alt: "Johny, Phnom Penh",
      quote: "“Product sart khop sari mg bro, nh order jrern dg hz.”",
      color: "#9d789b"
    },
    {
      name: "Lionel Messi",
      image: "images/messi1.jpg",
      alt: "Lionel, Siem Reap",
      quote: "“Order table muy tuk dak World Cup, sart nas bro bro.”",
      color: "#7a81a8"
    },
    {
      name: "ជឿន​ ចក់",
      image: "images/pujork.jpg",
      alt: "Chanthy, Battambang",
      quote: "“非常漂亮和奢华，我喜欢它”",
      color: "#6d5b98"
    },
    {
      name: "Thok Techhong",
      image: "images/kru.jpg",
      alt: "Piseth, Kampot",
      quote: "“ធធធធធធធធ”",
      color: "#6d5b98"
    },
    {
      name: "T-Rex",
      image: "images/trex.jpg",
      alt: "Sreyneang, Takeo",
      quote: "“Sart bro-Rawrr.”",
      color: "#ad7d52"
    }
  ];

  const prevBtn = document.getElementById("testimonialPrev");
  const nextBtn = document.getElementById("testimonialNext");

  // Select the card elements and their parent row for animation control
  const displayCards = Array.from(document.querySelectorAll(".testimonial-card")).slice(0, 3);
  const testimonialRow = document.querySelector(".testimonials .row:last-of-type"); // The row containing the cards

  // Hide the extra cards beyond the 3 display slots
  const allCardCols = Array.from(document.querySelectorAll(".testimonial-card")).map(card => card.closest('.col-12'));
  allCardCols.forEach((col, index) => {
    if (index >= 3) {
      col.style.display = 'none';
    }
  });

  let currentIdx = 0;
  let isAnimating = false;

  // --- 2. Update Function ---
  // This function now uses the slide animations from your CSS.
  function updateTestimonials(direction = 'next') {
    if (isAnimating) return;
    isAnimating = true;

    const animationClass = direction === 'next' ? 'testimonial-slide-in' : 'testimonial-slide-in-reverse';
    const parentAnimationClass = direction === 'next' ? 'parent-animate' : 'parent-animate-reverse';

    // 1. Update the content for all three cards immediately
    displayCards.forEach((card, i) => {
      const dataIndex = (currentIdx + i) % testimonialsData.length;
      const data = testimonialsData[dataIndex];

      // Update content
      card.querySelector('.card-up').style.backgroundColor = data.color;
      const img = card.querySelector('.avatar img');
      img.src = data.image;
      img.alt = data.alt;
      card.querySelector('h4').textContent = data.name;
      card.querySelector('.dark-grey-text').innerHTML = `<i class="fas fa-quote-left pe-2"></i>${data.quote}`;
      
      // 2. Prepare for animation: remove old classes
      card.classList.remove('testimonial-slide-in', 'testimonial-slide-in-reverse');
    });
    
    // Use a tiny timeout to ensure the DOM has registered the class removal before adding the new one
    setTimeout(() => {
        // 3. Add animation classes to trigger the slide-in effect
        testimonialRow.classList.add(parentAnimationClass);
        displayCards.forEach(card => {
            card.classList.add(animationClass);
        });
    }, 10);


    // 4. Clean up after the animation is finished
    setTimeout(() => {
      testimonialRow.classList.remove(parentAnimationClass);
      displayCards.forEach(card => {
        card.classList.remove(animationClass);
      });
      isAnimating = false;
    }, 450); // A bit longer than your 400ms animation to be safe
  }


  // --- 3. Event Listeners ---
  prevBtn.onclick = function () {
    currentIdx = (currentIdx - 1 + testimonialsData.length) % testimonialsData.length;
    updateTestimonials('prev');
  };

  nextBtn.onclick = function () {
    currentIdx = (currentIdx + 1) % testimonialsData.length;
    updateTestimonials('next');
  };

  // --- 4. Initial Load ---
  // On first load, we don't need to animate. Just set the initial state.
  function initialLoad() {
      displayCards.forEach((card, i) => {
        const dataIndex = (currentIdx + i) % testimonialsData.length;
        const data = testimonialsData[dataIndex];
        card.querySelector('.card-up').style.backgroundColor = data.color;
        const img = card.querySelector('.avatar img');
        img.src = data.image;
        img.alt = data.alt;
        card.querySelector('h4').textContent = data.name;
        card.querySelector('.dark-grey-text').innerHTML = `<i class="fas fa-quote-left pe-2"></i>${data.quote}`;
      });
  }
  
  initialLoad();
});

document.addEventListener("DOMContentLoaded", function () {
  const cards = document.querySelectorAll(".product-card");
  const nextBtn = document.getElementById("product-next-btn");
  const prevBtn = document.getElementById("product-prev-btn");
  const totalCards = cards.length;
  let currentIndex = 0;
  let autoSwapInterval;

  function updateCarousel(isInitial = false) {
    cards.forEach((card, index) => {
      // Remove all positional classes first
      card.classList.remove(
        "card-center-left",
        "card-center-right",
        "card-side-left",
        "card-side-right",
        "card-hidden"
      );

      // Determine the new positions for the 4 visible cards
      const centerLeftIndex = currentIndex;
      const centerRightIndex = (currentIndex + 1) % totalCards;
      const sideRightIndex = (currentIndex + 2) % totalCards;
      // Handle wrap-around for the previous index correctly
      const sideLeftIndex = (currentIndex - 1 + totalCards) % totalCards;

      if (index === centerLeftIndex) {
        card.classList.add("card-center-left");
      } else if (index === centerRightIndex) {
        card.classList.add("card-center-right");
      } else if (index === sideLeftIndex) {
        card.classList.add("card-side-left");
      } else if (index === sideRightIndex) {
        card.classList.add("card-side-right");
      } else {
        card.classList.add("card-hidden");
      }

      // Prevent animation on initial page load
      if (isInitial) {
        card.style.transition = 'none';
      } else {
        // Ensure transition is re-enabled after initial load
        card.style.transition = 'transform 0.6s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.6s ease, z-index 0s 0.3s';
      }
    });

    // A tiny timeout to re-enable transitions after the initial non-animated setup
    if(isInitial){
      setTimeout(() => {
        cards.forEach(card => card.style.transition = '');
      }, 50);
    }
  }
  
  // Function to reset and start the auto-swap timer
  function startAutoSwap() {
    clearInterval(autoSwapInterval); // Clear any existing timer
    autoSwapInterval = setInterval(() => {
      currentIndex = (currentIndex + 1) % totalCards;
      updateCarousel();
    }, 3000); // Swap every 3 seconds
  }

  // Event Listeners for buttons
  nextBtn.addEventListener("click", () => {
    currentIndex = (currentIndex + 1) % totalCards;
    updateCarousel();
    startAutoSwap(); // Reset timer on manual click
  });

  prevBtn.addEventListener("click", () => {
    currentIndex = (currentIndex - 1 + totalCards) % totalCards;
    updateCarousel();
    startAutoSwap(); // Reset timer on manual click
  });

  // Initial setup
  updateCarousel(true); // Set initial positions without animation
  startAutoSwap(); // Start the automatic swapping
});