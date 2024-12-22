
import {RecipeManager} from "./recipeManagment/RecipeManager.js";
import {RecipeSearch} from "./recipeSearch/recipeSearch.js";

if (document.getElementById("recipeForm")) {
    document.recipeManager = new RecipeManager();
}
if (document.getElementById("searchPage")) {
    document.recipeSearch = new RecipeSearch();
}