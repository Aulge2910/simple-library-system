<!DOCTYPE html>
 
 <html>
     <head>
         <meta charset="utf-8">
         <meta http-equiv="X-UA-Compatible" content="IE=edge">
         <title>My Demo Web2</title>
         <meta name="description" content="">
         <meta name="viewport" content="width=device-width, initial-scale=1">
        
         <!-- CSS references -->
 
         <link rel="stylesheet" href="css/main.css">
         <link rel="stylesheet" href="css/fonts/poppins/poppins.css">
         <link href="https://cdn.jsdelivr.net/npm/jarallax@2/dist/jarallax.min.css" rel="stylesheet">
 
 
         <!-- JS references -->
 
         <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
         <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
 
 
         <!-- GSAP references -->
 
         <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
         <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
         <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/TextPlugin.min.js"></script>
         <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/Observer.min.js"></script>
 
         <!-- typing effect -->
         <script src="https://unpkg.com/typeit@8.7.1/dist/index.umd.js"></script>
 
     
 
     </head>
    <body>
        <!-- header  -->
        <header class="container-fluid d-flex" id="header">
        <nav class="container navbar navbar-expand-lg w-100">
            <div class="container-fluid">
                <a class="navbar-brand " href="#">Logo</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0 mx-auto mb-2 mb-lg-0 fs-lg-5 gap-lg-2 gal-md-1 gap-sm-0">
                        <li class="nav-item ">
                            <a class="nav-link" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact Us</a>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <input class="w-25 flex-shrink-1 flex-fill" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-dark" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>
    
 
    <div id="toys-grid">
        <input type="hidden" name="rowcount" id="rowcount" />
    </div> 
   
 


    <!-- footer  -->
    <footer class="container-fluid">
        <div class="footer container row">
            <div class="footer__content col-lg-6 gap-lg-3 gap-md-2 gap-sm-1 gap-1">
                <h3>Online Library</h3>
                <span>We'd love to hear from you. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Iusto id et, repellat fuga maxime voluptas, quo, incidunt distinctio adipisci voluptatum ipsum delectus corrupti consectetur voluptates iure vitae soluta recusandae nemo.</span>
                <span>Follow Us</span>
                <div class="social-icon gap-1 my-1">
                    <a href="#"><i class="bi bi-facebook" aria-hidden="true"></i></a>
                    <a href="#"><i class="bi bi-instagram" aria-hidden="true"></i></a>
                    <a href="#"><i class="bi bi-twitter" aria-hidden="true"></i></a>
                    <a href="#"><i class="bi bi-github" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="footer__content col-lg-3 col-md-6  col-12  gap-lg-3 gap-md-2 gap-sm-1 gap-1">
                <h4>About Us</h4>
                <a href="#" class="link-none-decoration text--skewed"><span>Home</span></a>
                <a href="#" class="link-none-decoration text--skewed"><span>Service</span></a>
                <a href="#" class="link-none-decoration text--skewed"><span>About Us</span></a>
                <a href="#" class="link-none-decoration text--skewed"><span>Contact Us</span></a>
  
            </div>
            <div class="footer__content col-lg-3 col-md-6 col-12 gap-lg-3 gap-md-2 gap-sm-1 gap-1">
                <h4>Contact Us</h4>
                <span>(+60) 000-111-2222</span>
                <span>myemail@email.com</span>
            </div>
        </div>
   
        
  
    </footer>
 
<script type="text/javascript" src="assets/js/crud.js"></script>

</body>
 