gsap.registerPlugin(Observer);

 

//immediate run the testimonial function
(function (){

  //Testimonial Data to be inserted
  const testimonialData = [
    {url: './img/t01.jpg', author:"James Doe", description: "'Be yourself; everyone else is already taken. Life doesn't have to be perfect to be wonderful.'"},
    {url: './img/t02.jpg', author:"John Doe", description: "'My mama always said, life is like a box of chocolates. You never know what you're gonna get..'"},
    {url: './img/t03.jpg', author:"Bili Doe",description: "'You don't have to be great to start, but you have to start to be great.'"},
    {url: './img/t04.jpg', author:"Even Doe",description: "Insanity is doing the same thing, over and over again, but expecting different results."},
    {url: './img/t05.jpg', author:"Ben Doe",description: "Live in the sunshine, swim the sea, drink the wild air."},
  ];

  //Testimonial-box Prev and Next Button
  const tPrev = document.querySelector('#t-prev');
  const tNext = document.querySelector('#t-next');

  //Testiomonial data to be manipulated
  const testimonalAuthor = document.querySelector("#testimonal-author")
  const testimonalDescript = document.querySelector(".testimonial-box__right blockquote")
  const testimonalImage = document.querySelector(".testimonial-box__img img")

  //Testimonial index to be counted
  let i = 0;

  //While Next Button isClicked, increase the carousel index
  tNext.addEventListener('click',function(){
      i++;
      //if press faster, more than 8, it still goes to index 0
      i=i>=testimonialData.length?0:i;
      toggleTestimonialData();
  })

  //While Next Button isClicked, decrease the carousel index
  tPrev.addEventListener('click',function(){
    i--;
    i=i<0?testimonialData.length-1:i;
    toggleTestimonialData();
  })

  //Testimonial function to manipulate data
  function toggleTestimonialData(){
    testimonalImage.src = testimonialData[i].url;
    testimonalAuthor.innerHTML = testimonialData[i].author;
    testimonalDescript.innerHTML = testimonialData[i].description;
    document.querySelector(".testimonial-box__dots button.dots--active").classList.remove('dots--active');
    document.querySelector(`.testimonial-box__dots button:nth-child(${i+1})`).classList.add('dots--active');
  }

  //Testimonial Timer for automated function
  let startTestimonialTimer = setInterval(function(){
    tNext.click();
  },1500)

  //Paused Testimonial Timer while mouse enter
  const testimonialBox = document.querySelector(".testimonial-box");
  testimonialBox.addEventListener('mouseenter',function(){
    clearInterval(startTestimonialTimer);
  });

  //Resume Testimonial Timer while mouse leave
  testimonialBox.addEventListener('mouseleave',function(){
    startTestimonialTimer = setInterval(function(){
      tNext.click();
    },1500)
  });
})();

//back to top function
(function(){
  const backTop = document.querySelector('.back-top');
  backTop.addEventListener('click',function(){
    document.documentElement.scrollTop=0;
    //or this way
    //window.scrollTo(0,0)
})
})();
 
//typing effect
(function(){
  new TypeIt(".welcome-box__left h1", {
    strings: "Explore More With Us!",
    speed: 175,
    loop: true,
  }).go();
})();

//gsap function
//automated infinite scroll
(function(){

  let loop = horizontalLoop(".infinite-scroll-box__content-item", {speed: 1, repeat: -1});

  function setDirection(value) {
    if (loop.direction !== value) {
      gsap.to(loop, {timeScale: value, duration: 1.5, overwrite: false});
      loop.direction = value;
    }
  }

  Observer.create({
    target: window,
    type: "wheel,scroll",
    
    onDown: () => setDirection(1),
    onUp: () => setDirection(-1)
  })

  function horizontalLoop(items, config) {
    items = gsap.utils.toArray(items);
    config = config || {};
    let tl = gsap.timeline({repeat: config.repeat, paused: config.paused, defaults: {ease: "none"}, onReverseComplete: () => tl.totalTime(tl.rawTime() + tl.duration() * 100)}),
      length = items.length,
      startX = items[0].offsetLeft,
      
      times = [],
      widths = [],
      xPercents = [],
      curIndex = 0,
      pixelsPerSecond = (config.speed || 1) * 100,
      snap = config.snap === false ? v => v : gsap.utils.snap(config.snap || 1), // some browsers shift by a pixel to accommodate flex layouts, so for example if width is 20% the first element's width might be 242px, and the next 243px, alternating back and forth. So we snap to 5 percentage points to make things look more natural
      totalWidth, curX, distanceToStart, distanceToLoop, item, i;
    gsap.set(items, { // convert "x" to "xPercent" to make things responsive, and populate the widths/xPercents Arrays to make lookups faster.
      xPercent: (i, el) => {
        let w = widths[i] = parseFloat(gsap.getProperty(el, "width", "px"));
        xPercents[i] = snap(parseFloat(gsap.getProperty(el, "x", "px")) / w * 100 + gsap.getProperty(el, "xPercent"));
        return xPercents[i];
      }
    });
    gsap.set(items, {x: 0});
    totalWidth = items[length-1].offsetLeft + xPercents[length-1] / 100 * widths[length-1] - startX + items[length-1].offsetWidth * gsap.getProperty(items[length-1], "scaleX") + (parseFloat(config.paddingRight) || 0);
    for (i = 0; i < length; i++) {
      item = items[i];
      curX = xPercents[i] / 100 * widths[i];
      distanceToStart = item.offsetLeft + curX - startX;
      distanceToLoop = distanceToStart + widths[i] * gsap.getProperty(item, "scaleX");
      tl.to(item, {xPercent: snap((curX - distanceToLoop) / widths[i] * 100), duration: distanceToLoop / pixelsPerSecond}, 0)
        .fromTo(item, {xPercent: snap((curX - distanceToLoop + totalWidth) / widths[i] * 100)}, {xPercent: xPercents[i], duration: (curX - distanceToLoop + totalWidth - curX) / pixelsPerSecond, immediateRender: false}, distanceToLoop / pixelsPerSecond)
        .add("label" + i, distanceToStart / pixelsPerSecond);
      times[i] = distanceToStart / pixelsPerSecond;
    }
    function toIndex(index, vars) {
      vars = vars || {};
      (Math.abs(index - curIndex) > length / 2) && (index += index > curIndex ? -length : length); // always go in the shortest direction
      let newIndex = gsap.utils.wrap(0, length, index),
        time = times[newIndex];
      if (time > tl.time() !== index > curIndex) { // if we're wrapping the timeline's playhead, make the proper adjustments
        vars.modifiers = {time: gsap.utils.wrap(0, tl.duration())};
        time += tl.duration() * (index > curIndex ? 1 : -1);
      }
      curIndex = newIndex;
      vars.overwrite = true;
      return tl.tweenTo(time, vars);
    }
    tl.next = vars => toIndex(curIndex+1, vars);
    tl.previous = vars => toIndex(curIndex-1, vars);
    tl.current = () => curIndex;
    tl.toIndex = (index, vars) => toIndex(index, vars);
    tl.times = times;
    tl.progress(1, true).progress(0, true); // pre-render for performance
    if (config.reversed) {
      tl.vars.onReverseComplete();
      tl.reverse();
    }
    return tl;
  }

})();






















