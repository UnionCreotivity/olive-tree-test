import { gsap } from './gsap/esm/index.js'

export default function loadingJS () {

    function loading(tag) {
        let number = $(tag).html();
        let parse = parseInt(number);
      
        let test;
        let timeRun = setInterval(() => {
          test = parse++;
          $(tag).text(test);
          if (test == 99) clearInterval(timeRun);
        }, 50);
      }
      loading(".loading-progress");
}

  

  