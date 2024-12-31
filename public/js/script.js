
import {RecipeManager} from "./recipeManagment/RecipeManager.js";
import {RecipeSearch} from "./search/RecipeSearch.js";
import {UserProfile} from "./userProfileManagment/UserProfile.js";
import {IngredientManager} from "./ingredientManagment/IngredientManager.js";

if (document.getElementById("recipeForm")) {
    document.recipeManager = new RecipeManager();
}
if (document.getElementById("searchPage")) {
    document.recipeSearch = new RecipeSearch();
}
if (document.getElementById("profileCol")) {
    document.userProfile = new UserProfile();
}
if (document.getElementById("ingredientList")) {
    document.ingredientManager = new IngredientManager();
}

