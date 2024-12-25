import {PasswordChanger} from "./PasswordChanger.js";

class UserProfile {


    constructor() {

        document.getElementById("changePasswordForm").addEventListener(
            "submit", async (event) => {
                event.preventDefault()
                await this.#changePassword()

            }
        )

    }


    async #changePassword() {
        const currentPassword = document.getElementById("currentPassword").value;
        const newPassword = document.getElementById("newPassword").value;
        const confirmPassword = document.getElementById("confirmPassword").value;

        let message = await PasswordChanger.changePassword(currentPassword, newPassword, confirmPassword);

        let col = document.getElementById("profileCol");
        let alert = document.createElement("div");
        alert.className = "alert alert-warning alert-dismissible fade show mb-3";
        alert.role = "alert";
        alert.innerHTML = `
            <strong>${message}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `
        col.prepend(alert);

        document.getElementById("changePasswordForm").reset()

    }


}

export {UserProfile}