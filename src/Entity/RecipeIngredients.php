<?php

namespace App\Entity;

use App\Repository\RecipeIngredientsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RecipeIngredientsRepository::class)
 */
class RecipeIngredients
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Ingredients::class, inversedBy="recipeIngredients")
     */
    private $ingredient;

    /**
     * @ORM\ManyToOne(targetEntity=Recipes::class, inversedBy="recipeIngredients")
     * @ORM\JoinColumn(nullable=false)
     */
    private $recipe;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIngredient(): ?Ingredients
    {
        return $this->ingredient;
    }

    public function setIngredient(?Ingredients $ingredient): self
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    public function getRecipe(): ?Recipes
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipes $recipe): self
    {
        $this->recipe = $recipe;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
