import React from "react";
import { createRoot } from "react-dom/client";

export default function App({ children }) {
    return (
        <div>
            {/* Layout chung cho nhân viên */}
            <header
                style={{ background: "#f8fafc", padding: 16, fontWeight: 700 }}
            >
                Cafe Tùng - Nhân viên
            </header>
            <main style={{ minHeight: "80vh" }}>{children}</main>
            <footer
                style={{
                    background: "#f8fafc",
                    padding: 16,
                    textAlign: "center",
                }}
            >
                © 2025 Cafe Tùng
            </footer>
        </div>
    );
}

// Mount vào blade
if (document.getElementById("react-root")) {
    const Component = window.ReactPage || (() => <div>Không có nội dung</div>);
    createRoot(document.getElementById("react-root")).render(
        <App>
            <Component />
        </App>
    );
}
