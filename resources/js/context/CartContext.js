import React from "react";
import { createContext, useReducer } from "react";

export const CartContext = createContext();

const initialState = { cart: [] };

function reducer(state, action) {
  const cartList = state.cart;
  const cartItem = action.payload;

  switch (action.type) {
    case "ADD_TO_CART":
      const exist = cartList.find((item) => item.id === cartItem.id);

      if (exist) {
        const newCartList = cartList.map((item) =>
          item.id === cartItem.id ? { ...item, qty: item.qty + 1 } : item
        );

        return { cart: newCartList };
      }

      return { cart: [...cartList, cartItem] };

    case "REMOVE_TO_CART":
      return {
        cart: cartList.filter((item) => item.id !== cartItem.id),
      };

    case "REMOVE_QTY":
      const newCartList = cartList.map((item) =>
        item.id === cartItem.id ? { ...item, qty: item.qty - 1 } : item
      );
      return { cart: newCartList };

    case "CLEAR_CART":
      return { cart: [] };

    default:
      return state;
  }
}

const CartProvider = ({ children }) => {
  const [state, dispatch] = useReducer(reducer, initialState);

  return <CartContext.Provider value={{ state, dispatch }}>{children}</CartContext.Provider>;
};

export default CartProvider;
