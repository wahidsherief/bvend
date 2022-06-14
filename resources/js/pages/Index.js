import React from "react";
import ReactDOM from "react-dom/client";
// import { BrowserRouter } from "react-router-dom";
import Home from "./Home";
import CartProvider from "../context/CartContext";
import { Theme } from "../theme";

const root = ReactDOM.createRoot(document.getElementById("products"));
root.render(
  <React.StrictMode>
    <CartProvider>
      <Theme>
        <Home />
      </Theme>
    </CartProvider>
  </React.StrictMode>
);
