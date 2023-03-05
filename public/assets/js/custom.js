function convertFileToBase64(file) {
    return new Promise(function(resolve, reject) {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function() {
            resolve(reader.result);
        };
        reader.onerror = function(error) {
            reject(error);
        };
    });
}

function getProfile() {
    $.ajax({
        type: 'GET',
        url: '/api/user',
        headers: {
            'Authorization': 'Bearer ' + token
        },
        success: function(response) {
            $('#user-name').html(response.name);
        },
        error: function(xhr, status, error) {
            if (xhr.status === 401) {
                window.location.href = '/login';
            }
        }
    });
}

function userLogout() {
    const token = localStorage.getItem('token');
    $.ajax({
        type: 'POST',
        url: '/api/logout',
        headers: {
            'Authorization': 'Bearer ' + token
        },
        success: function(response) {
            localStorage.removeItem('token');
            window.location.href = '/login';
        },
        error: function(xhr, status, error) {
            if (xhr.status === 401) {
                window.location.href = '/login';
            }
        }
    });
}
