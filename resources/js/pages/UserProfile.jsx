import React, { useEffect, useState } from "react";
import axios from "axios";

const UserProfile = () => {
    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        axios
            .get("/api/user")
            .then((response) => {
                setUser(response.data);
                setLoading(false);
            })
            .catch(() => {
                setError("Không thể tải thông tin người dùng.");
                setLoading(false);
            });
    }, []);

    if (loading) return <div>Đang tải...</div>;
    if (error) return <div>{error}</div>;
    if (!user) return null;

    return (
        <div
            style={{
                maxWidth: 500,
                margin: "40px auto",
                background: "#fff",
                borderRadius: 8,
                boxShadow: "0 2px 8px #eee",
                padding: 24,
            }}
        >
            <h2 style={{ fontSize: 24, fontWeight: 700, marginBottom: 16 }}>
                Thông tin cá nhân
            </h2>
            <div>
                <strong>Họ tên:</strong> {user.name}
            </div>
            <div>
                <strong>Email:</strong> {user.email}
            </div>
            <div>
                <strong>Số điện thoại:</strong> {user.phone || "Chưa cập nhật"}
            </div>
            <div>
                <strong>Địa chỉ:</strong> {user.address || "Chưa cập nhật"}
            </div>
            <div>
                <strong>Vai trò:</strong> {user.role}
            </div>
            <div>
                <strong>Ngày tạo:</strong> {user.created_at}
            </div>
        </div>
    );
};

export default UserProfile;
