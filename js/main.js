'use strict';

const submitButtons = document.querySelectorAll('.submit')
const leave = document.querySelector('button.leave')
let loginErr
let passwordErr
let confirmErr
let emailErr
let nameErr

submitButtons.forEach(item => {
    item.addEventListener('click', async (e) => {
        e.preventDefault()
        if(item.classList.contains('submitAuth')){
            const login = document.querySelector('.inpLogin').value
            goAuth()
        }
        if(item.classList.contains('submitRegistration')){
            goRegistration()
        }  
    })
})

const goAuth = async () => {
    await fetch('./Controllers/AuthController.php', {
        method: 'POST',
        body: new FormData(document.querySelector('.formAuthorization'))
    })
    .then(res => res.json())
    .then(result => {
        Object.values(result[0])[0] === true && Object.values(result[1])[0] === true
        ? location.reload()
        : createErrorAuth(result)
    })
}
const goRegistration = async () => {
    await fetch('./Controllers/RegisterController.php',{
        method: 'POST',
        body: new FormData(document.querySelector('.formRegistration')),
        headers: {'X-Requested-With': 'XMLHttpRequest'}
    })
    .then(res => res.json())
    .then(result => {
        if(result === 1){
            getEmptyInputsRegister()
        }else {
            console.log(result)
            createErrorRegister(result)
        }
    })
}

const getEmptyInputsRegister = () => {
    const inputsRegistration = document.querySelectorAll('form.formRegistration input')
    const submit = document.querySelector('form.formRegistration input[type="submit"]')
    const errorSpans = document.querySelectorAll('form.formRegistration span')
    inputsRegistration.forEach(item => item.value = '')
    submit.value = 'успешно'
    errorSpans.forEach(item => item.textContent = '')
}

const createErrorAuth = (error) => {
    let AuthLoginErr = document.querySelector('.AuthLoginError')
    let AuthPasswordErr = document.querySelector('.AuthPasswordError')
    const submit = document.querySelector('form.formAuthorization input[type="submit"]')
    loginErr = passwordErr = ''
    error.forEach(err => {
        if(err.login){
            err.login === true ? loginErr = '' : loginErr = err.login
            AuthLoginErr.textContent = loginErr
        }
        if(err.password){
            passwordErr = err.password
            AuthPasswordErr.textContent = passwordErr
        }
    })
    submit.addEventListener('submit', ()=> goAuth)
}

const createErrorRegister = (error) => {
    let submit = document.querySelector('form.formRegistration input[type="submit"]')
    let LoginError = document.querySelector('span.LoginError')
    let passwordError = document.querySelector('span.passwordError')
    let confirmError = document.querySelector('span.confirmError')
    let emailError = document.querySelector('.emailError')
    let nameError = document.querySelector('.nameError')
    LoginError.textContent = passwordError.textContent = confirmError.textContent = nameError.textContent = emailError.textContent = ''
    
    error.forEach(item => {
        console.log(item)
        if(item.login){
            loginErr = item.login
            LoginError.textContent = loginErr
        }
        if(item.password) {
            passwordErr = item.password
            passwordError.textContent = passwordErr
        }
        if(item.confirm){
            confirmErr = item.confirm
            confirmError.textContent = confirmErr
        }
        if(item.email){
            emailErr = item.email
            emailError.textContent = emailErr
        }
        if(item.name){
            nameErr = item.name
            nameError.textContent = nameErr
        }
        
        submit.addEventListener('submit', goRegistration)
        
    })
}
