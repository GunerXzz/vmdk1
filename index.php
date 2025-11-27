<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/vendor.css">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="css/tiny-slider.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="shortcut icon" href="favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=add_shopping_cart" />
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Kantumruy+Pro:ital,wght@0,100..700;1,100..700&family=Koulen&family=Luckiest+Guy&family=Playball&family=Rubik:ital,wght@0,300..900;1,300..900&family=Signika:wght@300..700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/jquery3.6.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/SmoothScroll.js"></script>
    <script src="js/script.min.js"></script>
    <script src="js/autohide-nav.js"></script>
</head>
<body>
   <div class="container-sm|md|lg|xl" data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="50">
      <!-- Kbal Nav Bar -->
        <?php include 'header.php'; ?>
      <!-- End Nav Bar -->

      <!-- Hero -->
      <div id="hero" class="hero hero-bg">
          <div class="container">
            <div class="row justify-content-between">
              <div class="col-lg-5">
                <div class="intro-excerpt">
                  <h1>Modern Interior <span class="d-block">Furniture Collection</span></h1>
                  <p class="mb-4">Experience unmatched comfort and timeless style with our exclusive furniture collection, designed to elevate your living space beautifully.</p>
                  <button class="btn btn-border-reveal" onclick="location.href='shop.php'">Shop Now</button>
                </div>
              </div>
              <div class="col-lg-7">
                <div class="hero-img-wrap">
                  <img src="images/couch.png" class="img-fluid couch-img">
                </div>
              </div>
            </div>
          </div>
      </div>  
      <!-- End Hero -->

      <!-- Featured Products -->
      <div id="Shop" class="container">
        <div class="row">
          <div class="top-seller col-lg-7 col-md-12 mb-4 mb-lg-0">
            <h2 class="section-title">Top Seller</h2>
          </div>
        <div class="row">
          <!-- Cards column -->
          <div class="col-lg-8 col-md-12 box_body">
            <section class="cards">
              <article class="card card--1">
                <div class="card__info-hover">
                  <svg class="card__like" viewBox="0 0 24 24">
                    <span class="material-symbols-outlined">
                      add_shopping_cart 
                    </span>
                  </svg>
                  <div class="card__clock-info">
                    <svg class="card__clock" viewBox="0 0 24 24"><path d="M12,20A7,7 0 0,1 5,13A7,7 0 0,1 12,6A7,7 0 0,1 19,13A7,7 0 0,1 12,20M19.03,7.39L20.45,5.97C20,5.46 19.55,5 19.04,4.56L17.62,6C16.07,4.74 14.12,4 12,4A9,9 0 0,0 3,13A9,9 0 0,0 12,22C17,22 21,17.97 21,13C21,10.88 20.26,8.93 19.03,7.39M11,14H13V8H11M15,1H9V3H15V1Z" />
                    </svg><span class="card__time">In Stock</span>
                  </div>
                
                </div>
                <div class="card__img"></div>
                <a href="#" class="card_link">
                  <div class="card__img--hover"></div>
                </a>
                <div class="card__info">
                  <span class="card__category">Top Seller</span>
                  <h3 class="card__title">Crisp Spanish Wood</h3>
                  <span class="card__by">by <a href="#" class="card__author" title="author">Routine</a></span>
                </div>
              </article>

              <article class="card card--2">
                <div class="card__info-hover">
                  <svg class="card__like" viewBox="0 0 24 24">
                    <span class="material-symbols-outlined">
                      add_shopping_cart 
                    </span> 
                  </svg>
                  <div class="card__clock-info">
                    <svg class="card__clock" viewBox="0 0 24 24"><path d="M12,20A7,7 0 0,1 5,13A7,7 0 0,1 12,6A7,7 0 0,1 19,13A7,7 0 0,1 12,20M19.03,7.39L20.45,5.97C20,5.46 19.55,5 19.04,4.56L17.62,6C16.07,4.74 14.12,4 12,4A9,9 0 0,0 3,13A9,9 0 0,0 12,22C17,22 21,17.97 21,13C21,10.88 20.26,8.93 19.03,7.39M11,14H13V8H11M15,1H9V3H15V1Z" />
                    </svg><span class="card__time">In Stock</span>
                  </div>
                
              </div>
              <div class="card__img"></div>
              <a href="#" class="card_link">
                <div class="card__img--hover"></div>
              </a>
              <div class="card__info">
                <span class="card__category"> Top Seller</span>
                <h3 class="card__title">One Leg Minimalist</h3>
                <span class="card__by">by <a href="#" class="card__author" title="author">Ten 11</a></span>
              </div>
            </article>

            <article class="card card--3">
              <div class="card__info-hover">
                  <svg class="card__like"  viewBox="0 0 24 24">
                      <span class="material-symbols-outlined">
                        add_shopping_cart 
                      </span> 
                  </svg>
                  <div class="card__clock-info">
                    <svg class="card__clock"  viewBox="0 0 24 24"><path d="M12,20A7,7 0 0,1 5,13A7,7 0 0,1 12,6A7,7 0 0,1 19,13A7,7 0 0,1 12,20M19.03,7.39L20.45,5.97C20,5.46 19.55,5 19.04,4.56L17.62,6C16.07,4.74 14.12,4 12,4A9,9 0 0,0 3,13A9,9 0 0,0 12,22C17,22 21,17.97 21,13C21,10.88 20.26,8.93 19.03,7.39M11,14H13V8H11M15,1H9V3H15V1Z" />
                    </svg><span class="card__time">In Stock</span>
                  </div>
                
              </div>
              <div class="card__img"></div>
              <a href="#" class="card_link">
                <div class="card__img--hover"></div>
              </a>
              <div class="card__info">
                <span class="card__category "> Top Seller</span>
                <h3 class="card__title">Glass Half Moon</h3>
                <span class="card__by">by <a href="#" class="card__author" title="author">Zando</a></span>
              </div>
            </article>
          </section>
        </div>
        <!-- Text column -->
        <div class="col-lg-4 col-md-12">
          <div class="intro-excerpt_body">
            <h1>Excellent material <span class="d-block">Quality and Comfort</span></h1>
            <p class="mb-4">
              Discover our premium furniture collection,
              crafted for both elegance and everyday comfort.
              Transform your living space with quality you can trust.
            </p>
            <button class="btn btn-border-reveal" onclick="location.href='shop.php'">Explore the Menu</button>
          </div>
        </div>
    </div>
   </div>

 <!-- Feature Product -->
  <section class="featured-products-section">
  <h2 class="section-title">Featured Products</h2>
  <p class="section-subtitle">Discover our hand-picked collection of signature pieces.</p>

  <div class="product-carousel-container">
    <div class="product-carousel-wrapper">

      <div class="product-card">
        <div class="product-image-wrapper">
          <img src="images/8.jpg" alt="Rattan Chair">
        </div>
        <div class="product-details">
          <p class="product-category">Chair</p>
          <h3 class="product-name">Italian Oak</h3>
          <p class="product-price">$80.00</p>
        </div>
      </div>

      <div class="product-card">
        <div class="product-image-wrapper">
          <img src="images/4.jpg" alt="Woven Pendant Light">
        </div>
        <div class="product-details">
          <p class="product-category">Chair</p>
          <h3 class="product-name">Terk Ror Lork Black</h3>
          <p class="product-price">$220.00</p>
        </div>
      </div>

      <div class="product-card">
        <div class="product-image-wrapper">
          <img src="images/post-5.jpg" alt="Wooden Side Table">
        </div>
        <div class="product-details">
          <p class="product-category">Chair</p>
          <h3 class="product-name">Pool Sleeper</h3>
          <p class="product-price">$195.00</p>
        </div>
      </div>

      <div class="product-card">
        <div class="product-image-wrapper">
          <img src="images/2.jpg" alt="Bamboo Lantern">
        </div>
        <div class="product-details">
          <p class="product-category">Chair</p>
          <h3 class="product-name">Decent Oak</h3>
          <p class="product-price">$60.00</p>
        </div>
      </div>
      
      <div class="product-card">
        <div class="product-image-wrapper">
          <img src="images/5.jpg" alt="New Product">
        </div>
        <div class="product-details">
          <p class="product-category">Chair</p>
          <h3 class="product-name">Terk Ror Lork Red</h3>
          <p class="product-price">$150.00</p>
        </div>
      </div>

      <div class="product-card">
        <div class="product-image-wrapper">
          <img src="images/6.jpg" alt="New Product">
        </div>
        <div class="product-details">
          <p class="product-category">Chair</p>
          <h3 class="product-name">Sofa Whitening</h3>
          <p class="product-price">$3320.00</p>
        </div>
      </div>

      <div class="product-card">
        <div class="product-image-wrapper">
          <img src="images/7.jpg" alt="New Product">
        </div>
        <div class="product-details">
          <p class="product-category">Combo</p>
          <h3 class="product-name">Living Room Sofa Set</h3>
          <p class="product-price">$3210.00</p>
        </div>
      </div>

      <div class="product-card">
        <div class="product-image-wrapper">
          <img src="images/t1.jpg" alt="New Product">
        </div>
        <div class="product-details">
          <p class="product-category">Table</p>
          <h3 class="product-name">Vietnamese Oak Table</h3>
          <p class="product-price">$150.00</p>
        </div>
      </div>

    </div>

    <button id="product-prev-btn" class="carousel-btn prev">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
    </button>
    <button id="product-next-btn" class="carousel-btn next">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
    </button>

  </div>
  </section>

    <!-- End Featured Products -->


   <!-- About Us -->
      <div id="about" class="container my-5">
        <div class="row align-items-center">
          <!-- Text Column -->
          <div class="col-lg-7 col-md-12 mb-4 mb-lg-0">
            <h2 class="section-title ">About Us</h2>
            <p class="about-us-p mb-4">
              Inspired by Cambodia’s rich heritage, we blend traditional craftsmanship with modern design to create furniture that brings warmth and elegance to your home. Our mission is to support local artisans and communities while delivering exceptional quality and comfort.
            </p>
            <div class="row about-us-ul">
              <ul class="about-us-features list col-md-6 mb-0">   
                <li class="about-us-li mb-2">Support for Khmer artisans and rural communities</li>
                <li class="about-us-li mb-2">Eco-conscious sourcing from Cambodian forests</li>
                <li class="about-us-li mb-2">Showroom located in the heart of Phnom Penh</li>
              </ul>
              <ul class="about-us-features list col-md-6 mb-0">
                <li class="about-us-li mb-2">Exceptional customer service and support</li>
                <li class="about-us-li mb-2">Fast and reliable delivery across Cambodia</li>
                <li class="about-us-li mb-2">Promoting Cambodian culture through every piece</li>
              </ul>
            </div>
            <a href="about-us.php" class="btn btn-border-reveal mt-4">Learn More</a>
          </div>
          <!-- Image Column -->
          <div class="col-lg-5 col-md-12 text-center position-relative">
            <img src="images/post-2.jpg" alt="About Us" class="about-us-img img-fluid">
            <img src="images/post-1.jpg" alt="About Us" class="about-us-img img-fluid about-us-img-overlay">
          </div>
        </div>
      </div>
    <!-- End about us -->

    <!-- Services -->
      <div id="services" class="blog-section">
        <div class="container">
          <div class="row mb-5">
            <div class="col-md-6">
              <h2 class="section-title">Our Services</h2>
            </div>
          </div>

          <div class="row">

            <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0">
              <div class="post-entry">
                <a href="#" class="post-thumbnail"><img src="images/design.jpg" alt="Custom Design" class="img-fluid"></a>
                <div class="post-content-entry">
                  <h3><a href="#">Custom Furniture Design</a></h3>
                  <div class="meta">
                    <span>by <a href="#">Furni Team</a></span>
                  </div>
                  <p>
                    We create unique, tailor-made furniture pieces to perfectly fit your space and style, blending Cambodian craftsmanship with modern trends.
                  </p>
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0">
              <div class="post-entry">
                <a href="#" class="post-thumbnail"><img src="images/Vann-Molyvann-1024x663.jpg" alt="Consultation" class="img-fluid"></a>
                <div class="post-content-entry">
                  <h3><a href="#">Interior Consultation</a></h3>
                  <div class="meta">
                    <span>by <a href="#">Master Vann Molyvann</a></span>
                  </div>
                  <p>
                    Our team offers professional advice to help you choose the right furniture and layout for your home or business in Cambodia.
                  </p>
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0">
              <div class="post-entry">
                <a href="#" class="post-thumbnail"><img src="images/messi 3.jpg" alt="Delivery" class="img-fluid"></a>
                <div class="post-content-entry">
                  <h3><a href="#">Fast & Reliable Delivery</a></h3>
                  <div class="meta">
                    <span>by <a href="#">Messi Logistics</a></span>
                  </div>
                  <p>
                    Enjoy quick and secure delivery services across Cambodia, ensuring your furniture arrives safely and on time, every time.
                  </p>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    <!-- End Services -->


    <!-- Testimonials -->
      <div class="row d-flex justify-content-center align-items-center">
        <div class="col-md-10 col-xl-8 text-center">
        <h2 class="section-title">Customers Reviews</h2>
          <p class="section-subtitle">Discover what our customers have to say about our products and services.</p>
        </div>
      </div>
      <section class="testimonials">

      <div class="row">
        <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0">
          <div class="card testimonial-card">
            <div class="card-up" style="background-color: #9d789b;"></div>
            <div class="avatar mx-auto bg-white">
              <img src="images/johny sins.png" class="rounded-circle img-fluid" alt="Jonhny Sins, Phnom Penh" />
            </div>
            <div class="card-body">
              <h4 class="mb-4">Jonhny Sins</h4>
              <hr />
              <p class="dark-grey-text mt-4">
                <i class="fas fa-quote-left pe-2"></i>“Product sart khop sari mg bro, nh order jrern dg hz.”
              </p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0">
          <div class="card testimonial-card">
            <div class="card-up" style="background-color: #7a81a8;"></div>
            <div class="avatar mx-auto bg-white">
              <img src="images/johny sins.png" class="rounded-circle img-fluid" alt="Vannak, Siem Reap" />
            </div>
            <div class="card-body">
              <h4 class="mb-4">Jonhny Sins</h4>
              <hr />
              <p class="dark-grey-text mt-4">
                <i class="fas fa-quote-left pe-2"></i>“vmdK’s furniture blends tradition and modern style. The delivery was fast and the team was very helpful.”
              </p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0">
          <div class="card testimonial-card">
            <div class="card-up" style="background-color: #6d5b98;"></div>
            <div class="avatar mx-auto bg-white">
              <img src="images/ad-image-3.png" class="rounded-circle img-fluid" alt="Chanthy, Battambang" />
            </div>
            <div class="card-body">
              <h4 class="mb-4">Chanthy Keo</h4>
              <hr />
              <p class="dark-grey-text mt-4">
                <i class="fas fa-quote-left pe-2"></i>“I appreciate vmdK’s eco-friendly approach and their support for Khmer communities. My new sofa is beautiful and comfortable.”
              </p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0">
          <div class="card testimonial-card">
            <div class="card-up" style="background-color: #6d5b98;"></div>
            <div class="avatar mx-auto bg-white">
              <img src="images/ad-image-4.png" class="rounded-circle img-fluid" alt="Piseth, Kampot" />
            </div>
            <div class="card-body">
              <h4 class="mb-4">Piseth Lim</h4>
              <hr />
              <p class="dark-grey-text mt-4">
                <i class="fas fa-quote-left pe-2"></i>“The team at vmdK helped me choose the perfect pieces for my café. Guests always compliment the Khmer-inspired designs.”
              </p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0">
          <div class="card testimonial-card">
            <div class="card-up" style="background-color: #ad7d52;"></div>
            <div class="avatar mx-auto bg-white">
              <img src="images/ad-image-5.png" class="rounded-circle img-fluid" alt="Sreyneang, Takeo" />
            </div>
            <div class="card-body">
              <h4 class="mb-4">Sreyneang Phan</h4>
              <hr />
              <p class="dark-grey-text mt-4">
                <i class="fas fa-quote-left pe-2"></i>“I love how vmdK promotes Cambodian culture. The furniture is high quality and the service is excellent.”
              </p>
            </div>
          </div>
        </div>
      </div>
      <!-- Move the navigation buttons here, under the boxes -->
      <div class="row">
        <div class="col-12 text-center testimonial-buttons">
          <button id="testimonialPrev" class="btn btn-border-reveal me-2">Prev</button>
          <button id="testimonialNext" class="btn btn-border-reveal">Next</button>
        </div>
      </div>
      </section>
    <!-- End Testimonials -->

    <!-- footer -->
        <footer id="contact" class="mt-auto pt-5 pb-4">
          <div class="container">
            <div class="row">
              <!-- Company Information -->
              <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="fw-bold mb-3">About vmdK</h5>
                <p class="small mb-0">
                  Inspired by Cambodia’s heritage, vmdK blends traditional craftsmanship with modern design to create elegant, comfortable furniture. We support local artisans and deliver quality to homes across Cambodia.
                </p>
              </div>

              <!-- Quick Links -->
              <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="fw-bold mb-3">Quick Links</h5>
                <div class="row">
                  <div class="col-6">
                    <ul class="list-unstyled">
                      <li class="mb-2">
                        <a class="nav-link px-0" href="#hero">
                          <i class="bi bi-house me-2"></i>Home
                        </a>
                      </li>
                      <li class="mb-2">
                        <a class="nav-link px-0" href="#Shop">
                          <i class="bi bi-shop me-2"></i>Shop
                        </a>
                      </li>
                      <li class="mb-2">
                        <a class="nav-link px-0" href="#about">
                          <i class="bi bi-info-circle me-2"></i>About Us
                        </a>
                      </li>
                    </ul>
                  </div>
                  <div class="col-6">
                    <ul class="list-unstyled">
                      <li class="mb-2">
                        <a class="nav-link px-0" href="#services">
                          <i class="bi bi-gear me-2"></i>Services
                        </a>
                      </li>
                      <li>
                        <a class="nav-link px-0" href="#contact">
                          <i class="bi bi-envelope me-2"></i>Contact Us
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>

              <!-- Social Media & Contact -->
              <div class="col-md-4">
                <h5 class="fw-bold mb-3">Contact & Follow Us</h5>
                <ul class="list-unstyled mb-3">
                  <li class="mb-2"><i class="bi bi-geo-alt-fill me-2"></i>Phnom Penh, Cambodia</li>
                  <li class="mb-2"><i class="bi bi-telephone-fill me-2"></i>+855 12 345 678</li>
                  <li><i class="bi bi-envelope-fill me-2"></i>support@Vmdk.com.kh</li>
                </ul>
                <div class="footer-icons">
                  <a href="https://www.facebook.com" class="footer-icon me-3"><i class="fab fa-facebook-f fs-5"></i></a>
                  <a href="https://www.twitter.com" class="footer-icon me-3"><i class="fab fa-twitter fs-5"></i></a>
                  <a href="https://www.instagram.com" class="footer-icon me-3"><i class="fab fa-instagram fs-5"></i></a>
                  <a href="https://www.linkedin.com" class="footer-icon"><i class="fab fa-linkedin fs-5"></i></a>
                </div>
              </div>
            </div>

            <hr class="bg-secondary mt-4">

            <!-- Copyright -->
            <div class="row">
              <div class="col-12 text-center">
                <p class="mb-0 small text-secondary">&copy; 2025 VmdK Cambodia. All rights reserved.</p>
              </div>
            </div>
          </div>
        </footer>
    <!-- End footer -->
   </div>

</body>
</html>