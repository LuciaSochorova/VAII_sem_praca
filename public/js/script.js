
import {RecipeManager} from "./recipeManagment/RecipeManager.js";
import {RecipeSearch} from "./recipeSearch/RecipeSearch.js";
import {UserProfile} from "./userProfileManagment/UserProfile.js";

if (document.getElementById("recipeForm")) {
    document.recipeManager = new RecipeManager();
}
if (document.getElementById("searchPage")) {
    document.recipeSearch = new RecipeSearch();
}
if (document.getElementById("profileCol")) {
    document.uderProfile = new UserProfile();
}

