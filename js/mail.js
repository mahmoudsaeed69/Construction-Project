function send_mail(){
    let prams={
    name :document.getElementById("name-user").value,
    user:document.getElementById("email-user").value,
    phone:document.getElementById("phone-user").value,
    message:document.getElementById("message-user").value,
    subject:document.getElementById("subject-user").value,


}
console.log(prams)


emailjs.send("service_b5ke0ll","template_yetqi0y",prams).then(alert ("your mail is sent"))
}
