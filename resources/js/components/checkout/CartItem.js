import { Clear } from "@mui/icons-material";
import { Avatar, Box, Card, IconButton, Typography } from "@mui/material";
import React from "react";
import useCart from "../../hooks/useCart";

const CartItem = ({ product }) => {
  const { dispatch } = useCart();

  const handleDeleteFromCart = () => {
    dispatch({ type: "REMOVE_TO_CART", payload: product });
  };

  return (
    <Card
      sx={{
        mb: 1,
        padding: 1,
        boxShadow: 1,
        display: "flex",
        alignItems: "center",
        justifyContent: "space-between",
      }}
    >
      <Box sx={{ display: "flex", alignItems: "center", gap: 1.5 }}>
        <Avatar
          src={product.image}
          sx={{ backgroundColor: "secondary.100", borderRadius: "8px" }}
        />
        <Box>
          <Typography variant="p" fontSize={13} fontWeight={600} display="block">
            {product.title.substring(0, 15)}...
          </Typography>

          <Typography variant="p" fontSize={13} display="block">
            {product.qty} x {product.price}
          </Typography>
        </Box>
      </Box>

      <Box sx={{ display: "flex", alignItems: "center", gap: 1 }}>
        <Typography variant="p" fontSize={14} fontWeight={600} display="block">
          {(product.qty * product.price).toFixed(1)} Tk
        </Typography>

        <IconButton onClick={handleDeleteFromCart}>
          <Clear sx={{ fontSize: 14 }} />
        </IconButton>
      </Box>
    </Card>
  );
};

export default CartItem;
