import { Avatar, Badge, Box, Stack, Typography, Link } from "@mui/material";
import React from "react";
// import { NavLink } from "react-router-dom";
import { FlexBetween } from "../styles";

const BottomSheet = ({ show, cart = [] }) => {
  const totalAmount = cart.reduce((prev, curr) => prev + curr.qty * curr.price, 0);

  return (
    <Box
      sx={{
        padding: 1,
        height: 100,
        width: "100%",
        position: "fixed",
        bottom: show ? 0 : -120,
        backgroundColor: "primary.main",
        borderRadius: "12px 12px 0 0",
        transition: "bottom 0.4s ease",
      }}
    >
      <Stack direction="row" spacing={2} mt={1}>
        {cart.map((item) => (
          <Badge key={item.id} badgeContent={item.qty} overlap="circular" color="secondary">
            <Avatar src={item.image} sx={{ backgroundColor: "secondary.200" }} />
          </Badge>
        ))}
      </Stack>

      <FlexBetween mt={1}>
        <Typography variant="h6" fontSize={14} fontWeight={600} color="white">
          Total: {totalAmount.toFixed(2)} TK
        </Typography>

        <Link href={`/payment/${totalAmount.toFixed(2)}`} style={{ color: "white", fontWeight: 500, fontSize: 13 }}>
          Proceed &gt;&gt;
        </Link>
      </FlexBetween>
    </Box>
  );
};

export default BottomSheet;
