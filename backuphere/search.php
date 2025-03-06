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

    <!--Back to Top -->
    <div class="back-top">
        <i class="text-center bi-arrow-up label-up"></i>
        <span class="label-up">Back To Top</span>
    </div>
        

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
        
                </div>
            </div>
        </nav>
    </header>

 
 

        <div class="container search-bar">
            <div class="row border-1 search-bar__content" >
                <div class="col-sm col-md-3 col-lg-4" >
                    <input class="w-100 h-100 flex-shrink-1 flex-fill" type="search" placeholder="Search" aria-label="Search">
                </div>
                <div class="col-sm col-md-3 col-lg-4">
                    <select class="form-select" aria-label="Default select example"  >
                        <option selected>Category</option>
                        <option value="1">Adventure111</option>
                        <option value="2">Thrill</option>
                        <option value="3">Family</option>
                    </select>
                </div>

                <div class="col-sm col-md-3 col-lg-4">
                    <button class="btn btn-outline-dark w-100" type="submit">Search</button>
                </div>
            </div>
        </div>

    <form class="form" method="" action="" >

   
    <div id="search_data_ajax"class="container">
        <div class="row search-box">
            <div class="col-12 search-result">
                <h4>Result for 'Search Result'</h4>
                <span class="fw-light">xxx Results on TodayDate</span>
            </div>
            <div class="search-filter col-sm-12 col-md-4 col-lg-3">
                 <div class="filter-box">
                    <div class="filter-header">
                        All Category
                    </div>
                    <div class="filter-content">
                        <div class="filter-item">
                            <input type="checkbox" class="btn-check" id="btn-check" autocomplete="off" name="category">
                            <label class="btn btn-outline-dark" for="btn-check">Thrill</label>
                            <span class="float-end">Num</span>
                        </div>
                        <div class="filter-item">
                            <input type="checkbox" class="btn-check" id="btn-check2" autocomplete="off" name="category">
                            <label class="btn btn-outline-dark" for="btn-check2">Adventure</label>
                            <span class="float-end">54</span>
                        </div>
                    </div>
                 </div>

                 <div class="filter-box">
                    <div class="filter-header">
                        Publisher
                    </div>
                    <div class="filter-content">
                        <div class="filter-item">
                            <input type="checkbox" class="btn-check" id="btn-check3" autocomplete="off" name="category">
                            <label class="btn btn-outline-dark" for="btn-check">Thrill</label>
                            <span class="float-end">Num</span>
                        </div>
                        <div class="filter-item">
                            <input type="checkbox" class="btn-check" id="btn-check4" autocomplete="off" name="category">
                            <label class="btn btn-outline-dark" for="btn-check2">Adventure</label>
                            <span class="float-end">54</span>
                        </div>
                    </div>
                 </div>
            </div>
            <div class="search-content col-sm-12 col-md-8 col-lg-9">
                <div class="row search-sorting">
                    <div class="col-lg-2 col-md-4 col-sm-3 text-center d-flex justify-content-center align-items-center p-2">
                       <span> Sort By</span>
                    </div>
                    <div class="col-lg-10 col-md-8 col-sm-9 p-2">
                    <select class="form-select w-55 sortBy" aria-label="Default select example"  >
                        <option selected>Category</option>
                        <option value="adventure">Adventure</option>
                        <option value="thrill">Thrill</option>
                        <option value="family">Family</option>
                    </select>
                    </div>
                </div>

                <div class="row search-item-result">
                    <div class="search-item col-lg-4 col-md-6 col-sm-6">
                        <div class="search-item-cover">
                            <img src="./img/1.png">
                        </div>
                        <div class="search-item-detail">
                            <p>
                                Name
                            </p>
                            <span>'Category'</span>&nbsp;<span class="float-end">'Publisher'</span>
                            <p>Lorem ipsum, delectus quasi hic, error veniam aperiam et eius enim eveniet ipsa.</p>
                        </div>
                    </div>
                    <div class="search-item col-lg-4 col-md-6 col-sm-6">
                        <div class="search-item-cover">
                            <img src="./img/1.png">
                        </div>
                        <div class="search-item-detail">
                            <p>
                                Name
                            </p>
                            <span>'Category'</span>&nbsp;<span class="float-end">'Publisher'</span>
                            <p>Lorem ipsum, delectus quasi hic, error veniam aperiam et eius enim eveniet ipsa.</p>
                        </div>
                    </div>

                    <div class="search-item col-lg-4 col-md-6 col-sm-6">
                        <div class="search-item-cover">
                            <img src="./img/1.png">
                        </div>
                        <div class="search-item-detail">
                            <p>
                                Name
                            </p>
                            <span>'Category'</span>
                            <span class="float-end">'Publisher'</span>
                            <p>Lorem ipsum, delectus quasi hic, error veniam aperiam et eius enim eveniet ipsa.</p>
                        </div>
                    </div>
                    
                
                </div>
                


            </div>     
        </div>
    </div><div class="demotest"></div>
</form>


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

 
     </body>
     <script type="text/javascript" src="assets/js/crud.js"></script>
</html> 
    

 