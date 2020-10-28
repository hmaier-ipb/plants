<?php


class content
{

//card element
//first parameter is the image (pic.png) [string]
//second parameter is the description of the picture [string]
  function card_html($image,$description){
    return "<div class='card'>
            <div class='plant'>
                <div class='circle'></div>
                <img src='/plants/include/media/$image' alt='image'>
            </div>
            <div class='info'>
                <h1 class='title'>PLANT</h1>
                <h3>" .$description. "</h3>
                <div class='quantity'>
                  <span>Select your quantity</span><input type='number' name='quantity' min='1' max='20'>
                </div>
                <div class='purchase'>
                    <button>Purchase</button>
                </div>
            </div>
          </div>";
  }
}