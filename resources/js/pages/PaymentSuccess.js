import { CheckCircleOutline } from "@mui/icons-material";
import { Button, Container, Stack, Typography } from "@mui/material";
import React from "react";
import { useNavigate } from "react-router-dom";

const PaymentSuccess = () => {
  const navigate = useNavigate();

  return (
    <Container>
      <Stack alignItems="center" justifyContent="center" height="100vh">
        <Typography variant="h4" color="primary" fontWeight={700}>
          Box Opened
        </Typography>
        <Typography variant="p" color="grey.600" fontWeight={600}>
          Collect Your Product Now!
        </Typography>

        <CheckCircleOutline sx={{ color: "primary.main", fontSize: 140, my: 5 }} />

        <Typography variant="h6" fontWeight={700}>
          Payment Completed
        </Typography>

        <Button
          fullWidth
          variant="contained"
          onClick={() => navigate("/")}
          sx={{ mt: 5, py: 1.5, borderRadius: "8px" }}
        >
          Buy Again
        </Button>
      </Stack>
    </Container>
  );
};

export default PaymentSuccess;
