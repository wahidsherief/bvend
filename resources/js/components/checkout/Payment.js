import { Button, Card, Typography } from "@mui/material";
import React from "react";
import { useNavigate } from "react-router-dom";
import useCart from "../../hooks/useCart";
import { FlexBetween } from "../styles";

const Payment = () => {
  const { state, dispatch } = useCart();
  const navigate = useNavigate();

  const discount = 0;
  const subTotal = state.cart.reduce((prev, curr) => prev + curr.qty * curr.price, 0);
  const total = subTotal - discount;

  const handlePayment = () => {
    dispatch({ type: "CLEAR_CART" });
    navigate("/payment_complete");
  };

  return (
    <Card sx={{ mt: 3, padding: 2, borderRadius: "4px" }}>
      <FlexBetween mb={1}>
        <Typography variant="p" fontSize={13} fontWeight={500}>
          Sub Total
        </Typography>
        <Typography variant="p" fontSize={13} fontWeight={500}>
          {subTotal.toFixed(2)} Tk
        </Typography>
      </FlexBetween>

      <FlexBetween mb={1}>
        <Typography variant="p" fontSize={13} fontWeight={500}>
          Discount
        </Typography>
        <Typography variant="p" fontSize={13} fontWeight={500}>
          {discount.toFixed(2)} Tk
        </Typography>
      </FlexBetween>

      <FlexBetween mb={1}>
        <Typography variant="p" fontSize={13} fontWeight={600}>
          Total
        </Typography>
        <Typography variant="p" fontSize={13} fontWeight={600}>
          {total.toFixed(2)} Tk
        </Typography>
      </FlexBetween>

      <Button
        fullWidth
        variant="contained"
        onClick={handlePayment}
        sx={{ mt: 1, py: 1.5, borderRadius: "8px" }}
      >
        Pay with bKash
      </Button>
    </Card>
  );
};

export default Payment;
