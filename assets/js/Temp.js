// cambridge mean
javascript:(function(){ var word=document.getElementsByClassName("headword")[0].innerText; var wordEncode = encodeURI(word); var mean = document.getElementsByClassName("def-block")[0].innerText; var meanEncode = encodeURI(mean); location.href ="http://localhost/TempCambridge/GetData?Word="+wordEncode+"&Mean="+meanEncode;  })();


