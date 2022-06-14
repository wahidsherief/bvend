// import { ShoppingBag } from "@mui/icons-material";
import { Box, Container, Typography } from "@mui/material";
import React, { Fragment } from "react";
import { NavLink } from "react-router-dom";
import CartItem from "../components/PaymentScreen/CartItem";
import Payment from "../components/PaymentScreen/Payment";
// import Topbar from "../components/home/Topbar";
// import { FlexCenter } from "../components/styles";
import useCart from "../hooks/useCart";

const PaymentScreen = () => {
  const { state } = useCart();

  // if (state.cart.length === 0) {
  //   return (
  //     <FlexCenter height="100vh" flexDirection="column" p={2}>
  //       <ShoppingBag color="primary" sx={{ fontSize: 70, mb: 2 }} />
  //       <Typography variant="p" fontWeight={700} fontSize={14} mb={2}>
  //         You cart is empty!
  //       </Typography>

  //       <NavLink to="/" style={{ fontSize: 13, fontWeight: 600 }}>
  //         Go Home
  //       </NavLink>
  //     </FlexCenter>
  //   );
  // }

  return (
    <Fragment>

      <Container sx={{ py: 2 }}>
        <Box sx={{ maxHeight: "50vh", minHeight: "50vh", overflow: "auto" }}>
          {state.cart.map((product) => (
            <CartItem key={product.id} product={product} />
          ))}
        </Box>

        <Payment />
      </Container>
    </Fragment>
  );
};

export default PaymentScreen;
