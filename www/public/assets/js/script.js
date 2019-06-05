var s = document.querySelector('input[type="search"]');
    p = document.querySelector('p');
find = function(){
    var words = p.innerText.split(' ');
    i = words.length;
    word = '';

    while(--i) {
        word = words[i];
        if(word.toLowerCase() == s.value.toLowerCase()){
            words[i] = '<span class="highlight">' + word + "</span>";
        }
        else{

        }  
    }   

    p.innerHTML = words.join(' ');
}; 

s.addEventListener('keydown', find , false);
s.addEventListener('keyup', find , false);