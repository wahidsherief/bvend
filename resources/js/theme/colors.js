import { alpha } from "@mui/material/styles";

const primaryMain = "#007E33";
export const primary = {
  light: "#E5F3FD",
  main: primaryMain,
  100: alpha(primaryMain, 0.08),
  200: alpha(primaryMain, 0.2),
  300: alpha(primaryMain, 0.3),
  400: alpha(primaryMain, 0.4),
};

const secondaryMain = "#23C657";
export const secondary = {
  dark: "#011E3D",
  light: "#E3F0FF",
  main: secondaryMain,
  100: alpha(secondaryMain, 0.08),
  200: alpha(secondaryMain, 0.2),
  300: alpha(secondaryMain, 0.3),
  400: alpha(secondaryMain, 0.4),
};

export const info = {
  light: "#F4F4FF",
  main: "#8C8DFF",
  dark: "#0C53B7",
};
export const success = {
  light: "#EAFBF4",
  main: "#27CE88",
  dark: "#229A16",
};
export const warning = {
  light: "#FFFAF2",
  main: "#FFC675",
  dark: "#B78103",
};
export const error = {
  light: "#FFEBF1",
  main: "#FF316F",
  dark: "#B72136",
};

// For light theme
export const grey = {
  50: "#f9f9f9",
  100: "#eff3f5",
  200: "#D3E6F3",
  300: "#B1C9DC",
  400: "#8CA3BA",
  500: "#5F748D",
  600: "#455A79",
  700: "#2F4365",
  800: "#1E2E51",
  900: "#121F43",
};

export const action = {
  hoverOpacity: 0.04,
  focusOpacity: 0.12,
  disabledOpacity: 0.38,
  selectedOpacity: 0.08,
  activatedOpacity: 0.12,
  disabled: grey[300],
  selected: grey[100],
  hover: alpha(grey[900], 0.04),
  focus: alpha(grey[900], 0.12),
  active: alpha(grey[900], 0.54),
  disabledBackground: alpha(grey[900], 0.12),
};
