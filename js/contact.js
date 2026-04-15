const fields = {
    name: {
        input: document.getElementById('name'),
        error: document.getElementById('first-name-error'),
        validate: (val) => {
            if(!val) return 'First name is required.';
            if(val.length < 2) return 'First name must be at least 2 characters.';
            if(!/^[a-zA-Z\s]+$/.test(val)) return 'First name can only contain letters and spaces.';
            return '';
        }
    },
    lastName: {
        input: document.getElementById('last-name'),
        error: document.getElementById('last-name-error'),
        validate: (val) => {
            if(!val) return 'Last name is required.';
            if(val.length < 2) return 'Last name must be at least 2 characters.';
            if(!/^[a-zA-Z\s]+$/.test(val)) return 'Last name can only contain letters and spaces.';
            return '';
        }
    },
    phone: {
        input: document.getElementById('phone'),
        error: document.getElementById('phone-error'),
        validate: (val) => {
            if(!val) return 'Phone number is required.';
            if(!/^\+?[0-9\s\-]{7,15}$/.test(val)) return 'Please enter a valid phone number.';
            return '';
        }
    },
    email: {
        input: document.getElementById('email'),
        error: document.getElementById('email-error'),
        validate: (val) => {
            if(!val) return 'Email is required.';
            if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) return 'Please enter a valid email address.';
            return '';
        }
    },
    message: {
        input: document.getElementById('message'),
        error: document.getElementById('message-error'),
        validate: (val) => {
            if(!val) return 'Message is required.';
            if(val.length < 10) return 'Message must be at least 10 characters.';
            return '';
        }
    }
};

function showError(field, message) {
    field.error.textContent = message;
    field.error.style.color = 'red';
    field.input.style.borderColor = 'red';
}

function clearError(field) {
    field.error.textContent = '';
    field.input.style.borderColor = '';
}
Object.values(fields).forEach(field => {
    field.input.addEventListener('input', () => {
        const errorMessage = field.validate(field.input.value.trim());
        if (errorMessage) {
            showError(field, errorMessage);
        } else {
            clearError(field);
        }
    });
});

const form = document.querySelector('.contact-form');
form.addEventListener('submit', async (e) => {
    e.preventDefault();
    let isValid = true;
    Object.values(fields).forEach(field => {
        const errorMessage = field.validate(field.input.value.trim());
        if (errorMessage) {
            showError(field, errorMessage);
            isValid = false;
        } else {
            clearError(field);
        }
    });
    if (!isValid) return;

    const formData = new FormData(form);
    try{
        const response =await fetch('contact_handler.php', {
            method: 'POST',
            body: formData
        });
        const rawtext = await response.text();
        console.log("server response:", rawtext);
        const result = JSON.parse(rawtext);
        //const result = await response.json();
        if(result.success){
            alert('Your message has been sent successfully!');
            form.reset();
        } else {
            alert('There was an error sending your message. Please try again later server error: ' + result.error);
        }
    } catch (error) {
        alert('There was an error sending your message. Please try again later.');
    }   
});

