
/**
 * 
 * 
 * BIND FUNCTIONS AND CALL THEM ON THE FUNCTION CALL
 */

var greetingFuncs = [

]

var personalInfoFuncs = [

]

var userDataCollectedFuncs = [

]


var chatEndFuncs = [

]

var showCustomMessagesFuncs = [

]


/**@abstract


FUNCTION WHEN SEND BUTTON HIT
 */



var questionsMsgsObj = [
    {
        'Q': 'What is your name?',
        'A': "",
        "dataName": "username"
    },
    {
        'Q': 'What is your best email we can reach you at?',
        'A': "",
        "dataName": "email"
    },
    {
        'Q': 'What is your best phone number we can call you back at?',
        'A': "",
        "dataName": "phone-number"
    },
    // {
    //     'Q': 'How can we help you today?',
    //     'A': "",
    //     "dataName": "user-issue"
    // },
    {
        'Q': 'Thank you for your information today! An expert will connect with you very soon.',
        'A': "",
        "dataName": "good-bye-msg"
    },
    {
        'Q': 'Do You Want Your Messages to Be Mailed to You?. Say yes or no.',
        'A': "",
        "dataName": "email-or-not"
    },
]


/**
 * 
 * SEND A STARTER MSG
 */
let msgx = "Hi " + currentUserName + ", I'm " + botName + ", How can I assist you?";
let msg = getBotMsg(msgx)

$('.chat-logs').append(msg)
$(".spin-container").hide()


if (stopMsgs) {
    $("#chat-input__text").hide()
}




$('#chat-input__text').keypress(function (evt) {
    var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
    if (keyCode == 13) {
        $("#chat-submit").click()
    }
})

$("#chat-submit").click(function (e) {
    let nowGreeted = false


    if (stopMsgs) {
        endChat()
        return false
    }
    var msg_field = $('#chat-input__text')
    var msg_val = msg_field.val()
    var lowerMsg = msg_val.toLowerCase()

    /**
     * 
     * VALIDATION FIELDS
     */
    if (msg_field.attr("type") == "email" && !msg_val.includes("@")) {

        var msgx = "<span style='color:red'>Please Provide a Valid Email</span>"
        if (checkLastMsg(msgx)) {
            return false
        }
        let msg = getBotMsg(msgx)

        $('.chat-logs').append(msg)
        $(".spin-container").hide()
        scrollNow()
        return false
    }


    var check_phone_number = new RegExp("^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$");
    if (msg_field.attr("data-entered") == "phone-number" && !check_phone_number.test(lowerMsg) && msg_val != "") {

        let msgx = "<span style='color:red'>Please Provide a Valid Phone Number</span>"
        if (checkLastMsg(msgx)) {
            return false
        }
        let msg = getBotMsg(msgx)

        $('.chat-logs').append(msg)
        $(".spin-container").hide()


        scrollNow()
        return false
    }


    if (msg_val != "") {
        starterIncludes(msg_field, msg_val)

        // add msg to all OBJ
        allMsgs[(Object.keys(allMsgs).length + 1) + '_User'] = msg_val

        // asve user data if enterred
        saveUserData(msg_field, msg_val)

        // ADD USER MSG TO CHAT LIST
        $('.chat-logs').append(getUserMsg(msg_val))



        var check_for_greetings_words = new RegExp("(^hello|^hi|^hey|^" + botName.toLowerCase() + ")");
        var how_are_you_words = new RegExp("(how are you|are you fine|^you?/s$|are you?$)");

        // CHECK IF IT IS HI HEELO OR HOW ARE YOU 
        if (check_for_greetings_words.test(lowerMsg) && msg_field.attr("data-type")!="userData") {

            /**
             * 
             * 
             * GREETINGS MSGS
             * 
             * 
             */
            // console.log("greets")
            let gre = sendGreetings(msg_field, msg_val)
            greeted = true
            nowGreeted = true

            if (!gre) {
                return false
            }
        }


        var need_help_want = new RegExp("(^want|^help|^need)");

        // ================= CHECK IF FEEDBACK RECIEVED================
        if(msg_field.attr("data-entered")=="feedback"){
            sendFeedback()
        }
        ////////// CHECK FOR want help need
        
        else if (need_help_want.test(lowerMsg)) {
            msg_field.attr("data-type", "userData")
            getPersonalInfo(msg_field, msg_val)
        }
        else if (how_are_you_words.test(lowerMsg) && msg_field.attr("data-type")!="userData") {

            /**
             * 
             *  // ASK QUESTIONS 
             */

            // getDataFromDB(msg_field,msg_val)
            iAmFine(msg_field, msg_val)

        }
        else if (msg_field.attr("data-type") == "userData" || msg_val.includes("customer support")) {

            /**
             * 
             *  // ASK QUESTIONS 
             */

            getPersonalInfo(msg_field, msg_val)

        }


        // msg_val.includes("?") || 
        else {

            /**
             * 
             * GET DATA FROM BACKEND
             * 
             */
            if (!nowGreeted) {


                var getDBData = getDataFromDB(msg_field, msg_val)

                if (getDBData == false) {

                    getPersonalInfo(msg_field, msg_val)
                }
            }
        }

        scrollNow()


    } // if msg it not empty if ends here
    else {
        console.log("input empty")
    }
})









function sendGreetings(msg_field, msg_val) {

    if (!greeted) {
        bot_msg_text = "Hi " + currentUserName;

        var botMsg = getBotMsg(bot_msg_text)
        allMsgs[(Object.keys(allMsgs).length + 1) + '_Bot'] = bot_msg_text

        if (msg_field.attr("data-type") != "userData") {
            $('.chat-logs').append(botMsg)

            $(".spin-container").hide()

            msg_field.attr("data-type", 'normal')

            greeted = true
            scrollNow()
        }


    }

    // CHECK IF HE USED NEED HELP WORDDS
    var need_help_want = new RegExp("(want|help|need)");
    if (need_help_want.test(msg_val.toLowerCase())) {
        msg_field.attr("data-type", "userData")
        getPersonalInfo(msg_field, msg_val)
        return false
    }


    greetingFuncs.forEach(function (ind, ele) {
        // console.log("inds", ind)
        window[ind]();
    })
}





function iAmFine(msg_field, msg_val) {
    let bot_msg_text = "I'm great. Thanks for asking."
    var botMsg = getBotMsg(bot_msg_text)
    setTimeout(function () {
        $('.chat-logs').append(botMsg)

        $(".spin-container").hide()

        msg_field.attr("data-type", 'normal')

        greeted = true
        scrollNow()
    }, 800);
}







function getPersonalInfo(msg_field, msg_val, secs = 800) {

    // check of user thanked the bot at the end
    if (msg_field.attr("data-entered") == "good-bye-msg") {

        var thank_you_or_not = new RegExp("(thank you|thanks|thank)");
        if (thank_you_or_not.test(msg_val.toLowerCase())) {
            let msgx = "You’re very welcome!"

            // console.log("thanked", questionsMsgsObj[askedQuestions].dataName)

            if (checkLastMsg(msgx)) {
                return false
            }

            let botMsg = getBotMsg(msgx)
            $('.chat-logs').append(botMsg)

        }
    }




    // CHECK IF USER DATA TAKEN and Msging after that
    if (questionsMsgsObj.length == 0 && (!askPersonalInfoAgain)) {

        let msgx = "Thank you for providing us with your contact details today. Our expert will connect with you very soon!"
        if (checkLastMsg(msgx)) {
            return false
        }


        if (stopMsgs) {
            $("#chat-input__text").hide()
        }


        let msg = getBotMsg(msgx)

        $('.chat-logs').append(msg)
        $(".spin-container").hide()

        stopMsgs = true;
        return false
    }

    // IF QUESTION END END ASKING PERSOANL DATA
    if (questionsMsgsObj.length == askedQuestions && askPersonalInfoAgain) {
        msg_field.attr("data-type", 'normal')
        msg_field.attr("data-entered", "")

        if (msg_val.includes("yes")) {

            //======================= SEND EMAIL TO USER
            emailToUser();

            let msgx = "Your email will be sent to you right away. <br>Thank You for Contacting us today!."
            if (checkLastMsg(msgx)) {
                return false
            }
            let msg = getBotMsg(msgx)

            $('.chat-logs').append(msg)


            msgx = `Need More Help? <br> <a type='button' href='tel:${adminContactNumber}' class='btn f-16 btn-sm rounded mb-2 mr-2  btn-info' > Call Now (${adminContactNumber}) </a> <br> <a type='button' href='sms:${adminContactNumber}' class='btn f-16 btn-sm rounded mb-2 mr-2  btn-info' > Text Now (${adminContactNumber}) </a> <br> <a href='#' class='btn f-16 btn-sm rounded mb-2 mr-2 btn-info' onclick='callWhatsapp(\"${adminWhatsapp}\")' > WhatsApp Us (${adminWhatsapp}) </a> <a href='mailto:${adminEmail}' class='btn f-16 btn-sm rounded mb-2 mr-2 btn-info' > Email Us </a>`

            msg = getBotMsg(msgx)

            $('.chat-logs').append(msg)

            $(".spin-container").hide()


        }
        else {

            let msgx = "Thank you for contacting us today! Have a blessed day!"
            if (checkLastMsg(msgx)) {
                return false
            }
            let msg = getBotMsg(msgx)

            $('.chat-logs').append(msg)
            $(".spin-container").hide()

        }

        //=================== ADMIN EMAIL
        emailToAdmin()


        // CALL TO ALL BINDING FUNCS

        userDataCollectedFuncs.forEach(function (ind, ele) {
            window[ind]();
        })



        // call all functions at end of personal data ask
        //instantiate new object
        stopMsgs = true;
        addConfetti()
        endChat()

        // CLEAR OUT THE DATA
        questionsMsgsObj = []
        askedQuestions = 0
        askPersonalInfoAgain = false

        return false



    }



    // ...////  ASKING QUESTIONS
    setTimeout(function () {

        // check if first msg 
        if (askedQuestions == 0) {
            let msgx = "Let me get you to a professional that can answer all of your questions.";
            let botMsg = getBotMsg(msgx)
            allMsgs[(Object.keys(allMsgs).length + 1) + '_Bot'] = msgx
            $('.chat-logs').append(botMsg)
        }


        var botMsg = getBotMsg(questionsMsgsObj[askedQuestions].Q)
        // AD BOT MSG
        allMsgs[(Object.keys(allMsgs).length + 1) + '_Bot'] = questionsMsgsObj[askedQuestions].Q


        $('.chat-logs').append(botMsg)
        $(".spin-container").hide()

        // SET DATA FIELDS TO GET USER DATA
        enteringUserData = true

        msg_field.attr("data-type", 'userData')
        msg_field.attr("data-entered", questionsMsgsObj[askedQuestions].dataName)

        if (questionsMsgsObj[askedQuestions].dataName == "email") {
            msg_field.attr("type", "email")
        }
        else {
            msg_field.attr("type", "text")
        }







        askedQuestions++
        scrollNow()
    }, secs);




    personalInfoFuncs.forEach(function (ind, ele) {

        window[ind]();
    })
    scrollNow()
}




function getDataFromDB(msg_field, msg_val) {

    var ret = true
    // console.log(restRouteUrl)
    $.post({
        "url": restRouteUrl + "ai_chat_bot/get-matched-data",
        "data": { 'msg': msg_val },
        "success": function (data) {

            if (data.length == 0) {
                // CALL FOR PERSONAL MESSAGES IF NOR FOUND ANY
                getPersonalInfo(msg_field, msg_val, 0)
                return false
            }
            else {
                // go on here 

                CustomMessages = data;
                showCustomMessages()

            }
        },
        "fail": function (data) {
            // console.log("failed")
            return false;
        },
        "error": function (xhr, status, error) {
            // var err = eval("(" + xhr.responseText + ")");
            alert(error)
        }
    })

}










function showCustomMessages(called_from = "db_func") {
    // console.log("called")

    //CHECK FROM WEHRE CALLED
    if (called_from == "db_func") {
        showedCustomMessages = 0;

        let msgx = CustomMessages[showedCustomMessages] + " <br>  <div style='display:flex;justify-content:space-between'> <a class='notusefull_a' onclick='showCustomMessages(\"from_notusefull\")'> Not Usefull? </a> <a class='notusefull_a' onclick='showContactMsg()'> Contact Us? </a> </div>"
        if (checkLastMsg(msgx)) {
            return false
        }
        let msg = getBotMsg(msgx)

        $('.chat-logs').append(msg)
        $(".spin-container").hide()
        showedCustomMessages++;
        return false
    }



    // CHECK IF ALL MESSAFES SHOWD OR NOT
    if (CustomMessages.length == showedCustomMessages) {
        // getPersonalInfo(msg_field,msg_val)
        if (questionsMsgsObj.length != askedQuestions) {
            enteringUserData = true
            $("#chat-input__text").val("customer support")
            $("#chat-input__text").attr("data-type", 'userData')
            $("#chat-input__text").attr("data-entered", questionsMsgsObj[askedQuestions].dataName)
            $("#chat-submit").trigger("click")
        }
        else {

            let msgx = "Thank you for Contacting Us..."
            if (checkLastMsg(msgx)) {
                return false
            }
            let msg = getBotMsg(msgx)

            $('.chat-logs').append(msg)
            $(".spin-container").hide()
        }

        showedCustomMessages = 0
    }
    else {

        let msgx = CustomMessages[showedCustomMessages] + " <br> <div style='display:flex;justify-content:space-between'> <a class='notusefull_a' onclick='showCustomMessages(\"from_notusefull\")'> Not Usefull? </a> <a class='notusefull_a' onclick='showContactMsg()'> Contact Us? </a> </div>"
        if (checkLastMsg(msgx)) {
            return false
        }
        let msg = getBotMsg(msgx)

        $('.chat-logs').append(msg)
        $(".spin-container").hide()
        showedCustomMessages++;
    }



    showCustomMessagesFuncs.forEach(function (ind, ele) {
        window[ind]();
    })
}


function callWhatsapp($number) {

    var url = `https://api.WhatsApp.com/send?phone=${$number}`
    window.open(url, '_blank').focus();
}



function showContactMsg() {
    initiateOrResetVars()

    $('.chat-logs').find(".chat-msg").remove() 


    
    $("#chat-input__text").trigger("click")

    let msgx = `<a type='button' href='tel:${adminContactNumber}' class='btn f-16 btn-sm rounded mb-2 mr-2  btn-info' > Call Now (${adminContactNumber}) </a> <br> <a type='button' href='sms:${adminContactNumber}' class='btn f-16 btn-sm rounded mb-2 mr-2  btn-info' > Text Now (${adminContactNumber}) </a> <br> <a href='#' class='btn f-16 btn-sm rounded mb-2 mr-2 btn-info' onclick='callWhatsapp(\"${adminWhatsapp}\")' > WhatsApp Us (${adminWhatsapp}) </a> <a href='mailto:${adminEmail}' class='btn f-16 btn-sm rounded mb-2 mr-2 btn-info' > Email Us </a>  <br> <a href='#' class='btn f-16 btn-sm rounded mb-2 mr-2 btn-warning' onclick='contactBtnClick()'> Share Contact Info Here </a>`
    if (checkLastMsg(msgx)) {
        return false
    }

    let msg = getBotMsg(msgx)

    $('.chat-logs').append(msg)
    $(".spin-container").hide()

    scrollNow()
}

function contactBtnClick() {

    $("#chat-input__text").val("customer support")
    $("#chat-input__text").attr("data-type", 'userData')
    $("#chat-input__text").attr("data-entered", questionsMsgsObj[askedQuestions].dataName)
    $("#chat-submit").trigger("click")
}


function saveUserData(msg_field, msg_val) {
    /// +++++++++++++++  IF ENTERING USER DATA SAVE IT 
    if (msg_field.attr("data-type") == "userData") {
        UserPersonalData[msg_field.attr('data-entered')] = msg_val
    }

}


function chatWithHuman() {
    $("#chat-input__text").trigger("click")
    $(".spin-container").show()

    let msgx = `Provide your information here so our Expert can get to you.`
    if (checkLastMsg(msgx)) {
        return false
    }
    let msg = getBotMsg(msgx)
    $('.chat-logs').find(".chat-msg").remove()
    initiateOrResetVars()
    $('.chat-logs').append(msg)

    setTimeout(function () {

        getPersonalInfo($("#chat-input__text"), $("#chat-input__text").val())

        $(".spin-container").hide()

        scrollNow()
    }, 600)


}



function askFeedback() {
    msg_field=$("#chat-input__text")

    $(".spin-container").show()   
    
    $('.chat-logs').find(".chat-msg").remove() 
    initiateOrResetVars()
    msg_field.trigger("click")

    setTimeout(function () {

        let msgx = `How was your experience with us today?`
        if (checkLastMsg(msgx)) {
            return false
        }
        let msg = getBotMsg(msgx)
        $('.chat-logs').append(msg)

        msg_field.attr("data-entered","feedback")
        $(".spin-container").hide()
    }, 1000)

    
}



function starterIncludes(msg_field, msg_val) {
    $(".spin-container").show()
    msg_field.val("")
}



function scrollNow() {
    // SCROLL
    var objDiv = document.getElementsByClassName("chat-logs")[0];
    objDiv.scrollTop = objDiv.scrollHeight;
}












function emailToUser() {
    var msg = '';
    for (let ind in allMsgs) {
        msg += "<b>" + (ind.toLowerCase().includes("user") ? "You" : "Bot") + " </b>: " + allMsgs[ind] + " <br>";
    }


    $.post({
        "url": restRouteUrl + "ai_chat_bot/send-email-user",
        "data": { 'msgs': " " + msg + " ", "send_to": UserPersonalData['email'] },
        "success": function (data, status, xhr) {
            // console.log("resp", xhr)
            msgx = data[0]
            if (msgx == "Email Sent Failed") {
                askPersonalInfoAgain = true

                // msgx += " <br> Do You Want To Try Again? <br> <a href='#' onclick='contactBtnClick()'> Yes </a> <a href='#' onclick='showContactMsg()'> No </a>"
            }

            if (checkLastMsg(msgx)) {
                return false
            }
            let msg = getBotMsg(msgx)

            $('.chat-logs').append(msg)
            $(".spin-container").hide()
        },
        "fail": function (data) {
            // console.log("failed")
            return false;
        },
        "error": function (xhr, status, error) {
            // var err = eval("(" + xhr.responseText + ")");
            alert(xhr.responseText)
        }
    })


}



function emailToAdmin() {
    var msg = '';
    for (let ind in allMsgs) {
        msg += "<b>" + (ind
            .toLowerCase().includes("user") ? "You" : "Bot") + " </b>: " + allMsgs[ind] + " <br>";
    }

    var personalD = ''
    for (let ind in UserPersonalData) {
        personalD += "<b>" + ind + " </b>: " + UserPersonalData[ind] + " <br>";
    }



    $.post({
        "url": restRouteUrl + "ai_chat_bot/send-email-admin",
        "data": { 'msgs': " " + msg + " ", "user_data": " " + personalD + " ", "send_to": adminEmail },
        "success": function (data) {
            // console.log("admin email", data)
        },
        "fail": function (data) {
            // console.log("failed")
            return false;
        },
        "error": function (xhr, status, error) {
            // var err = eval("(" + xhr.responseText + ")");
            alert(error)
        }
    })
}


function sendFeedback(msg_val) {

    var personalD = ''
    for (let ind in UserPersonalData) {
        personalD += "<b>" + ind + " </b>: " + UserPersonalData[ind] + " <br>";
    }



    $.post({
        "url": restRouteUrl + "ai_chat_bot/send-email-admin",
        "data": { 'msgs': " " + msg_val + " ", "user_data": " " + personalD + " ", "send_to": adminEmail, "subject":"Feedback Received From "+botName+" Chatbot" },
        "success": function (data) {
            $(".spin-container").hide()
        },
        "fail": function (data) {
            // console.log("Feedback failed")
            return false;
        },
        "error": function (xhr, status, error) {
            // var err = eval("(" + xhr.responseText + ")");
            alert(error)
        }
    })

    
}







function checkLastMsg(msg) {
    //Prevent from sending same msgs consectively
    if (lastBotMsg == msg) {
        return true
    }
}



function serializeMyData(MyObj) {
    let allM = {};
    for (let item in MyObj) {
        allM[item] = MyObj[item]
    }
    return allM;
}





function endChat() {

    stopMsgs = true

    $("#chat-input__text").hide()




    // console.log("stop msgs");
    let confetti = new Confetti('confetti');
    /*variable*/ /*library*/

    //options
    confetti.setCount(250);
    confetti.setSize(1.3);
    confetti.setPower(30);
    confetti.setFade(true);
    confetti.destroyTarget(false);

    setTimeout(function () {
        var el = document.getElementById("confetti");
        clickOnElem(el, 'center');
    }, 500)


    initiateOrResetVars()
}




// ----------------------------------------------------------------------- EXTRAS --------------------------


function clickOnElem(elem, offsetX, offsetY) {

    // console.log("testttting ");
    var rect = elem.getBoundingClientRect(),
        posX = rect.left, posY = rect.top; // get elems coordinates
    // calculate position of click
    if (typeof offsetX == 'number') posX += offsetX;
    else if (offsetX == 'center') {
        posX += rect.width / 2;
        if (offsetY == null) posY += rect.height / 2;
    }
    if (typeof offsetY == 'number') posY += offsetY;
    // create event-object with calculated position
    var evt = new MouseEvent('click', { bubbles: true, clientX: posX, clientY: posY });
    elem.dispatchEvent(evt); // trigger the event on elem
}








// ============================ CONFETTI ============================

function addConfetti() {

}


