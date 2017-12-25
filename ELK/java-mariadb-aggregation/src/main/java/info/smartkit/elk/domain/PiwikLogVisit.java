package info.smartkit.elk.domain;

import lombok.Getter;
import lombok.Setter;
import lombok.ToString;

import javax.persistence.*;
import java.io.Serializable;
import java.io.UnsupportedEncodingException;
import java.util.Date;

//@see： https://developer.piwik.org/2.x/guides/persistence-and-the-mysql-backend#log-data-persistence
@Entity
@Table(name = "piwik_log_visit")
//@Getter
//@Setter
@ToString
public class PiwikLogVisit implements Serializable{

    private static final long serialVersionUID = -1574204092853306884L;


    @Id
//    @GeneratedValue
    private String idvisit;

    public String getIdvisit() {
        return idvisit;
    }

    public void setIdvisit(String idvisit) {
        this.idvisit = idvisit;
    }

    public String getIdvisitor() {
        return new String(idvisitor);
    }

    public void setIdvisitor(byte[] idvisitor) {
        this.idvisitor = idvisitor;
    }

    public String getVisit_last_action_time() {
        return visit_last_action_time;
    }

    public void setVisit_last_action_time(String visit_last_action_time) {
        this.visit_last_action_time = visit_last_action_time;
    }

    public String getUser_id() {
        return user_id;
    }

    public void setUser_id(String user_id) {
        this.user_id = user_id;
    }

    public String getLocation_ip() {
        String result  = "";
        try {
            result = new  String(location_ip, "UTF-16LE");
        } catch (UnsupportedEncodingException e) {
            e.printStackTrace();
        }
        return result;
    }

    public void setLocation_ip(byte[] location_ip) {
        this.location_ip = location_ip;
    }

//    private String idvisit;

    public String getIdsite() {
        return idsite;
    }

    public void setIdsite(String idsite) {
        this.idsite = idsite;
    }

    private String idsite;
//    @Column(name = "first_name", nullable = false)
    private byte[] idvisitor;
    private String visit_last_action_time;
    private String user_id;
    private byte[] location_ip;

}
