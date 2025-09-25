import streamlit as st 
import pandas as pd
import os

# ------------------------
# DATOS BASE
# ------------------------
equipos = [
    "404 NOT TEAM", "Aperture Science", "Aqua Search", "Biojorbial", 
    "BITREALBIT", "Bytes4Water", "Chiclayo Boys", "Coder Sisters", 
    "Data4Earth", "dataclean", "DataM", "DataMakers", "Dataverde", 
    "DataVerde SEP", "DATUSAT", "Delta", "Digital Future Lab", 
    "EcoAnalytics", "EcoByte", "EcoData", "ECOFISCALIZADORES 2025", 
    "EcoInsight", "EcoMinds", "EcoNautas", "EcoPredict MPM", "EcoSfera", 
    "Ecosistema de Datos", "GOTA A GOTA EL AGUA SE AGOTA", 
    "Green Data Lovers", "Grupo L", "HERMES", "Hope", "HYDRA_DCP", 
    "HydroGeo", "IMPULSANDO LA CIENCIA CON DATOS", "INNOVA SSES", 
    "INTESACENTERv2", "Juan", "Los P-daters", "Los Vengadores", 
    "Marea Cero", "NaturIA", "Naylamp Research", "Roots of Science", 
    "Sostenible", "TakeItPunch", "Team awuita", "The Data Kings - TDK", 
    "TLNS", "Trébol económico", "Tridente", "Tridente Ambiental", 
    "Trilogía del agua", "Trío Ecoluz", "Triple Null", 
    "Unasitos Ambientalistas", "WindTech", "Yachayaku", "Yaku Data", 
    "Yaku Maki", "Yaku Ñawpaq"
]

criterios = {
    "Integración de datasets": [6, 12, 16, 24, 30],
    "Innovación y creatividad": [5, 10, 15, 20, 25],
    "Escalabilidad y replicabilidad": [5, 10, 15, 20, 25],
    "Impacto en la toma de decisiones": [2, 4, 6, 8, 10],
    "Claridad y calidad de la presentación final": [2, 4, 6, 8, 10]
}

archivo_csv = "evaluaciones.csv"

# ------------------------
# FUNCIONES
# ------------------------
def cargar_datos():
    if os.path.exists(archivo_csv):
        return pd.read_csv(archivo_csv)
    else:
        return pd.DataFrame(columns=["Jurado", "Equipo"] + list(criterios.keys()) + ["Total"])

def guardar_datos(df):
    df.to_csv(archivo_csv, index=False)

# ------------------------
# INTERFAZ
# ------------------------
st.set_page_config(page_title="Evaluación Datatón 2025", layout="wide")

st.title("📊 Evaluación Datatón 2025")

menu = st.sidebar.radio("Navegación", ["Registrar evaluación", "Ver resultados"])

df = cargar_datos()

if menu == "Registrar evaluación":
    with st.form("formulario"):
        jurado = st.text_input("👩‍⚖️ Nombre del jurado")
        equipo = st.selectbox("👥 Selecciona el equipo", equipos)

        puntajes = {}
        for criterio, valores in criterios.items():
            puntajes[criterio] = st.selectbox(f"{criterio}", valores, key=criterio)

        submit = st.form_submit_button("✅ Guardar evaluación")

    if submit:
        if jurado and equipo:
            total = sum(puntajes.values())
            nueva_eval = {
                "Jurado": jurado,
                "Equipo": equipo,
                **puntajes,
                "Total": total
            }
            df = pd.concat([df, pd.DataFrame([nueva_eval])], ignore_index=True)
            guardar_datos(df)
            st.success(f"Evaluación guardada para {equipo} por {jurado}. Total: {total}")
        else:
            st.error("⚠️ Debes ingresar el nombre del jurado y seleccionar un equipo.")

elif menu == "Ver resultados":
    if df.empty:
        st.info("Aún no hay evaluaciones registradas.")
    else:
        st.subheader("📋 Evaluaciones registradas")
        st.dataframe(df)

        st.subheader("🏆 Ranking por promedio de puntajes")
        ranking = df.groupby("Equipo")["Total"].mean().reset_index()
        ranking = ranking.sort_values(by="Total", ascending=False).reset_index(drop=True)
        ranking.index += 1
        st.dataframe(ranking)
