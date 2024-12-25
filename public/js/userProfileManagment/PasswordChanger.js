class PasswordChanger {

    static async changePassword(currentPassword, newPassword, confirmPassword) {
        if (newPassword.length < 6) {
            return "Nové heslo músi mať aspoň 6 znakov!"
        }
        if (newPassword !== confirmPassword) {
            return "Zadané nové heslá sa nezhodujú!"
        }
        try {
            let response = await fetch(
                "http://localhost/?c=passwordApi&a=change",
                {
                    method: "POST",
                    body: JSON.stringify({
                        currentPassword: currentPassword,
                        newPassword: newPassword,
                        confirmPassword: confirmPassword
                    }),
                    headers: {
                        "Content-type": "application/json",
                        "Accept": "application/json",
                    }
                }
            )
            if (response.status === 204) {
                return "Heslo zmenené."
            } else if (response.status === 422) {
                return "Zadané údaje boli nesprávne!"
            } else {
                return "Heslo sa nepodarilo zmeniť!"
            }

        } catch (e) {
            return "Heslo sa nepodarilo zmeniť!";
        }
    }


}

export {PasswordChanger}