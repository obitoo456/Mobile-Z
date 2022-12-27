
document.querySelector(".profile").onclick=function(){
document.querySelector(".menu").style.display='flex';


}



window.onload=function(){
    document.querySelector(".loader").style.display="none";
    if(document.querySelector(".profile form .avatars")){

document.querySelector(".profile form .avatars").onclick=function(){
    
    document.querySelector(".profile .container .box-avatars").style.display="flex";

        document.querySelector(".close").onclick=function(){

            document.querySelector(".profile .container .box-avatars").style.display="none";

        }
    let imgs = document.querySelectorAll(".profile .container .box-avatars img");
    console.log(imgs);
    imgs.forEach((img)=>{
        img.onclick=function(){
            document.querySelectorAll("form input[name='img']").forEach((input)=>{
                input.remove();
            })

            document.querySelector(".profile form .avatars img").remove();
            let imgc=img.cloneNode();
            document.querySelector(".profile form .avatars").append(imgc);

            let input = document.createElement("input");
            input.type="hidden";
            input.name="img";
            input.value=img.src.slice(-20)
            document.querySelector("form").prepend(input);

        }
    })
    

}}


;}