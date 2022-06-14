import MenuIcon from "@mui/icons-material/Menu";
import { AppBar, Box, Container, IconButton, Toolbar } from "@mui/material";
import React from "react";

const Topbar = () => {
  return (
    <AppBar position="static" sx={{ py: 2, boxShadow: 2, background: "transparent" }}>
      <Container>
        <Toolbar sx={{ justifyContent: "space-between" }}>
          <Box width={120}>
            <img src="/assets/bvend_logo.png" width="100%" alt="Logo" />
          </Box>

          <IconButton size="large">
            <MenuIcon />
          </IconButton>
        </Toolbar>
      </Container>
    </AppBar>
  );
};

export default Topbar;
