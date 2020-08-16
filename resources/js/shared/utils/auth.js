export function isLoggedIn(){
    return localStorage.getItem("isLoggedIn") == 'true';
}

export function isUserId(){
    return localStorage.getItem("userId");
}

export function isUserRole(){
    return localStorage.getItem("userRole");
}

export function logIn(data){
    localStorage.setItem("isLoggedIn", true);
}

export function logOut(){
    localStorage.setItem("isLoggedIn", false);
    localStorage.setItem("userId", null);
    localStorage.setItem("userRole", null);
}
