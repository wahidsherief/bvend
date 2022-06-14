import React from "react";
import { createTheme, CssBaseline, ThemeProvider } from "@mui/material";
import { action, grey, info, primary, secondary, success, warning } from "./colors";
import { shadows } from "./shadows";

export const Theme = ({ children }) => {
  let theme = createTheme({
    direction: "ltr",
    typography: { fontFamily: "'Montserrat', sans-serif" },
    breakpoints: {
      values: {
        xs: 0,
        sm: 600,
        md: 900,
        lg: 1200,
        xl: 1536,
      },
    },
    palette: {
      grey,
      info,
      action,
      primary,
      success,
      warning,
      secondary,
    },
    shadows,

    components: {
      MuiCssBaseline: {
        styleOverrides: {
          "*": {
            margin: 0,
            padding: 0,
            boxSizing: "border-box",
          },
          html: {
            width: "100%",
            height: "100%",
            WebkitOverflowScrolling: "touch",
            MozOsxFontSmoothing: "grayscale",
            WebkitFontSmoothing: "antialiased",
          },
          a: { textDecoration: "none" },
          body: { width: "100%", height: "100%" },
          "#root": { width: "100%", height: "100%" },
        },
      },

      MuiToolbar: {
        styleOverrides: { root: { paddingLeft: 0, paddingRight: 0 } },
      },
      MuiCard: {
        styleOverrides: { root: { boxShadow: shadows[4], borderRadius: 8 } },
      },
      MuiButton: {
        styleOverrides: { root: { minWidth: "auto", padding: "5px 10px" } },
      },
    },
  });

  return (
    <ThemeProvider theme={theme}>
      <CssBaseline />
      {children}
    </ThemeProvider>
  );
};
