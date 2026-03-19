let alert = document.querySelector('.base-alert')
let start_alert = true;
let lastExecutionTime = 0;

async function delay(ms) {
    return await new Promise(resolve => setTimeout(resolve, ms));
}

// функция верного алерта
async function success_alert(text) {
    let mass = alert.querySelector('.massage-save-alert')
    let container = alert.querySelector('.alert')
    if (start_alert) {
        start_alert = false;
        container.classList.add('alert-success')
        if (mass) {
            mass.innerHTML = text;
        }
        await delay(3000)
        start_alert = true
        container.classList.remove('alert-success')
        mass.innerHTML = ''
    }else {
        container.classList.remove('alert-success')
        await delay(3000)
        start_alert = true
        await success_alert(text)
    }
}

// функция ошибки алерта
async function error_alert(text) {
    let mass = alert.querySelector('.massage-save-alert')
    let container = alert.querySelector('.alert')
    if (start_alert) {
        start_alert = false;
        container.classList.add('alert-danger')
        if (mass) {
            mass.innerHTML = text;
        }

        await delay(3000)
        start_alert = true
        mass.innerHTML = ''
        container.classList.remove('alert-danger')
    }else {
        container.classList.remove('alert-danger')
        await delay(3000)
        start_alert = true
        await error_alert(text)
    }
}

//событие при нажатие на кнопку закрытия алерта
document.querySelector('.btn-close-save-alert').addEventListener('click', function (){
    let container = alert.querySelector('.alert')
    let mass = alert.querySelector('.massage-save-alert')
    container.classList.remove('alert-success')
    container.classList.remove('alert-danger')
    mass.innerHTML = ''
})
