package com.vlotar.demo.domain;

import lombok.Getter;
import lombok.Setter;
import lombok.ToString;

import javax.persistence.*;
import java.io.Serializable;
import java.util.Date;

@Entity
@Table(name = "piwik_log_visit")
//@Getter
//@Setter
@ToString
public class PiwikLogVisit implements Serializable{

    private static final long serialVersionUID = -1574204092853306884L;

    public Long getId() {
        return id;
    }

    public void setId(Long id) {
        this.id = id;
    }

    @Id
    @GeneratedValue
    private Long id;

    public String getIdvisit() {
        return idvisit;
    }

    public void setIdvisit(String idvisit) {
        this.idvisit = idvisit;
    }

    public String getIdvisitor() {
        return idvisitor;
    }

    public void setIdvisitor(String idvisitor) {
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
        return location_ip;
    }

    public void setLocation_ip(String location_ip) {
        this.location_ip = location_ip;
    }

    private String idvisit;
//    @Column(name = "first_name", nullable = false)
    private String idvisitor;
    private String visit_last_action_time;
    private String user_id;
    private String location_ip;

}
